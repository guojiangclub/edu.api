<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Server\Http\Controllers;

use Carbon\Carbon;
use iBrand\Common\Controllers\Controller;
use iBrand\Component\Pay\Facades\Charge;
use iBrand\Component\Pay\Facades\PayNotify;
use iBrand\Component\Pay\Models\Charge as ChargeModel;
use GuoJiangClub\Edu\Core\Applicators\VipApplicator;
use GuoJiangClub\Edu\Core\Models\CourseOrderAdjustment;
use GuoJiangClub\Edu\Core\Processes\CourseOrderProcess;
use GuoJiangClub\Edu\Core\Repositories\CourseMemberRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseOrderRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseRepository;
use GuoJiangClub\Edu\Core\Repositories\UserDetailsRepository;
use GuoJiangClub\Edu\Core\Repositories\VipMemberRepository;
use GuoJiangClub\Edu\Core\Services\CourseService;
use GuoJiangClub\Edu\Core\Services\DiscountService;
use iBrand\Component\Discount\Applicators\DiscountApplicator;
use iBrand\Component\Discount\Repositories\CouponRepository;

class CourseOrderController extends Controller
{
    protected $order;
    protected $course;
    protected $coupon;
    protected $discountService;
    protected $discountApplicator;
    protected $details;
    protected $vipMember;
    protected $member;
    protected $courseService;

    public function __construct(CourseOrderRepository $orderRepository, CourseRepository $courseRepository,
                                CouponRepository $couponRepository, DiscountService $discountService,
                                DiscountApplicator $discountApplicator, UserDetailsRepository $detailsRepository,
                                CourseMemberRepository $courseMemberRepository,
                                CourseService $courseService,
                                VipMemberRepository $vipMemberRepository)
    {
        $this->order = $orderRepository;
        $this->course = $courseRepository;
        $this->coupon = $couponRepository;
        $this->discountService = $discountService;
        $this->discountApplicator = $discountApplicator;
        $this->details = $detailsRepository;
        $this->vipMember = $vipMemberRepository;
        $this->member = $courseMemberRepository;
        $this->courseService = $courseService;
    }

    public function create()
    {
        $user = request()->user();

        $courseId = request('course_id');

        $userDetails = $this->details->findByUser($user->id);

        $needPay = true;

        $course = $this->course->find($courseId);

        $order = $this->order->create(['sn' => build_order_no('E'), 'status' => 'created', 'course_id' => $courseId,
            'items_total' => $course->price, 'total' => $course->price, 'user_id' => $user->id, 'title' => $course->title,]);

        if (0 === $order->total && $userDetails) {
            $needPay = false;

            $order = app(CourseOrderProcess::class)->paid($order);

            return $this->success(compact('needPay', 'order'));
        }

        $vipMember = $this->vipMember->getActiveByUser($user->id)->first();
        /*$isVip = $vipMember ? true : false;*/
        $isVip = false;

        $freeCourseCount = 0;

        if ($isVip) {
            $useCount = CourseOrderAdjustment::where('origin_type', 'vip')->where('origin_id', $vipMember->id)->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })->get()->count();

            $freeCourseCount = $vipMember->plan->getFreeCourseCount() - $useCount;

            app(VipApplicator::class)->calculate($order, $vipMember);
        }

        //get available coupons
        list($coupons, $bestCouponID, $bestCouponAdjustmentTotal) = $this->getOrderCoupons($order, $user);

        return $this->success(compact('needPay', 'order', 'freeCourseCount', 'userDetails', 'course', 'coupons', 'bestCouponID', 'bestCouponAdjustmentTotal', 'isVip', 'vipMember'));
    }

    public function charge()
    {
        $sn = request('order_no');

        $user = request()->user();

        $order = $this->order->getOrderBySN($sn);

        /*$vipMembers = $this->vipMember->getActiveByUser($user->id);

        if ($vipMembers->count() > 0) {
            $isUseVip = request('use_vip') ? true : false;
            app(VipApplicator::class)->apply($order, $vipMembers->first(), $isUseVip);
        }*/

        if (request('coupon_id') && $coupon = $this->coupon->find(request('coupon_id'))) {
            if (null != $coupon->used_at) {
                return $this->failed('此优惠券已被使用');
            }
            if ($user->can('update', $coupon) and $this->discountService->checkCoupon($order, $coupon)) {
                $this->discountApplicator->apply($order, $coupon);
                $coupon->used_at = null;
                $coupon->save();
            } else {
                return $this->failed('优惠券信息有误，请确认后重试');
            }
        }

        if (config('ibrand.edu.pay_debug') && $order->total > 0) {
            $order->total = 1;
        }

        if (request('note')) {
            $order->note = request('note');
        }

        $order->save();

        $type = 'charge';

        if (0 === $order->total) {
            $order = app(CourseOrderProcess::class)->paid($order);

            $type = 'paid';

            return $this->success(compact('type', 'needPay', 'order'));
        }

        $channel = request('channel') ?? 'wx_lite';

        if ('wx_lite' == $channel) {
            $charge = Charge::create(['channel' => request('channel') ?? 'wx_lite', 'order_no' => $sn, 'amount' => $order->total, 'client_ip' => \request()->getClientIp(), 'subject' => $order->title, 'body' => $order->title, 'extra' => ['openid' => \request('openid')],
            ]);

            return $this->success(compact('type', 'charge', 'order'));
        }

        $chargeModel = ChargeModel::create([
            'app' => 'default', 'type' => 'course_bd', 'channel' => $channel, 'order_no' => $sn, 'client_ip' => request()->getClientIp(), 'amount' => $order->total, 'subject' => $order->title, 'body' => $order->title, 'extra' => request('extra'),
        ]);

        if ('wx_pub' == $channel) {
            // $redirectUrl = route('payment.wechat.getCode', ['charge_id' => $chargeModel->charge_id]);
            $redirectUrl = 'https://guojiang.club/payment/getCode?charge_id=' . $chargeModel->charge_id;
        }

        if ('alipay_wap' == $channel) {
            $redirectUrl = route('payment.alipay.pay', ['charge_id' => $chargeModel->charge_id]);
        }

        return $this->success(compact('type', 'redirectUrl'));
    }

    public function paid()
    {
        $user = request()->user();

        $order_no = request('order_no');

        //在pay_debug=true 状态下，可以调用此接口直接更改订单支付状态
        if (request('charge_id')) {
            //同步查询微信订单状态，防止异步通信失败导致订单状态更新失败
            $charge = Charge::find(request('charge_id'));
            PayNotify::success($charge->type, $charge);
            $order_no = isset($charge->order_no) ? $charge->order_no : '';
        }

        if (!$order_no || !$order = $this->order->getOrderBySN($order_no)) {
            return $this->failed('订单不存在');
        }
        if ($user->cant('update', $order)) {
            return $this->failed('无权操作.', ['order' => $order]);
        }

        if ('paid' != $order->status) {
            $payRecords = \GuoJiangClub\Component\Pay\Models\Charge::ofPaidOrderNo($order_no)->get();
            if ($payRecords->count() > 0 && $payRecords->sum('amount') >= $order->total) {
                $order->status = 'paid';
                $order->paid_at = Carbon::now();
                $order->payment = $payRecords->first()->channel;
                $order->save();
            }
        }
        if ('paid' == $order->status) {
            $coteries = null;

            $this->courseService->becomeStudent($order);

            return $this->success(['order' => $order, 'payment' => '微信支付', 'coteries' => $coteries]);
        }

        return $this->success(['order' => $order]);
    }

    private function getOrderCoupons($order, $user)
    {
        $bestCouponID = 0;
        $bestCouponAdjustmentTotal = 0;
        $cheap_price = 0;

        $coupons = app(DiscountService::class)->getEligibilityCoupons($order, $user->id);

        if ($coupons) {
            $bestCoupon = $coupons->sortBy('adjustmentTotal')->first();

            if ($bestCoupon->orderAmountLimit > 0 and $bestCoupon->orderAmountLimit > ($order->total + $cheap_price)) {
                $bestCouponID = 0;
            } else {
                $bestCouponID = $bestCoupon->id;
                $bestCouponAdjustmentTotal = -$bestCoupon->adjustmentTotal;
            }
            $coupons = collect_to_array($coupons);
        } else {
            $coupons = [];
        }

        return [$coupons, $bestCouponID, $bestCouponAdjustmentTotal];
    }
}
