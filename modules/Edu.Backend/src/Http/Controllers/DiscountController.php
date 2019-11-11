<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Http\Controllers;

use Carbon\Carbon;
use DB;
use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use GuoJiangClub\Edu\Backend\Models\Discount;
use GuoJiangClub\Edu\Backend\Models\DiscountAction;
use GuoJiangClub\Edu\Backend\Models\DiscountRule;
use GuoJiangClub\Edu\Backend\Repositories\CouponRepository;
use GuoJiangClub\Edu\Backend\Repositories\CourseOrderAdjustmentRepository;
use GuoJiangClub\Edu\Backend\Repositories\DiscountRepository;
use iBrand\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class DiscountController extends Controller
{
    protected $discountRepository;

    protected $courseOrderAdjustmentRepository;

    protected $couponRepository;

    public function __construct(
        DiscountRepository $discountRepository, CourseOrderAdjustmentRepository $courseOrderAdjustmentRepository, CouponRepository $couponRepository
    ) {
        $this->discountRepository = $discountRepository;

        $this->courseOrderAdjustmentRepository = $courseOrderAdjustmentRepository;

        $this->couponRepository = $couponRepository;
    }

    public function index()
    {
        $condition = $this->getCondition();
        $where = $condition[0];
        $orWhere = $condition[1];

        if (isset($where['channel'])) {
            unset($where['channel']);
        }

        $coupons = $this->discountRepository->getDiscountList($where, $orWhere);

        return LaravelAdmin::content(function (Content $content) use ($coupons) {
            $content->header('优惠券列表');

            $content->breadcrumb(
                ['text' => '优惠券管理', 'url' => '/edu/discount/list', 'no-pjax' => 1],
                ['text' => '优惠券列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '优惠券管理']
            );

            $content->body(view('edu-backend::discount.coupon.index', compact('coupons')));
        });
    }

    public function create()
    {
        $discount = new Discount();
        $roles = DiscountRule::all();

        return LaravelAdmin::content(function (Content $content) use ($discount, $roles) {
            $content->header('新增优惠券');

            $content->breadcrumb(
                ['text' => '优惠券管理', 'url' => 'edu/discount/list', 'no-pjax' => 1],
                ['text' => '新增优惠券', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '优惠券管理']
            );

            $content->body(view('edu-backend::discount.coupon.create', compact('discount', 'roles')));
        });
    }

    public function edit($id)
    {
        $discount = Discount::find($id);
        $roles = DiscountRule::all();

        return LaravelAdmin::content(function (Content $content) use ($discount, $roles) {
            $content->header('编辑优惠券');

            $content->breadcrumb(
                ['text' => '优惠券管理', 'url' => 'edu/discount/list', 'no-pjax' => 1],
                ['text' => '编辑优惠券', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '优惠券管理']
            );

            $content->body(view('edu-backend::discount.coupon.edit', compact('discount', 'roles')));
        });
    }

    /**
     * 使用记录.
     *
     * @return mixed
     */
    public function useRecord()
    {
        $id = request('id');
        $limit = request('limit') ? request('limit') : 15;
        $condition = $this->usedCondition();
        $time = $condition[0];
        $where = $condition[1];
        $userwhere = $condition[2];
        $orderwhere = $condition[3];

        $couponLists = $this->couponRepository->findWhere(['discount_id' => $id]);

        $origin_id = [];

        if ($couponLists->count()) {
            foreach ($couponLists as $item) {
                $origin_id[] = $item->id;
            }
        }

        $coupons = $this->courseOrderAdjustmentRepository->getOrderAdjustmentHistory($where, $time, $userwhere, $orderwhere, $limit, $origin_type = ['coupon'], $origin_id);

        return LaravelAdmin::content(function (Content $content) use ($coupons, $id) {
            $content->header('使用记录');

            $content->breadcrumb(
                ['text' => '优惠券管理', 'url' => 'edu/discount/list', 'no-pjax' => 1],
                ['text' => '使用记录', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '优惠券管理']
            );

            $content->body(view('edu-backend::discount.coupon.use_record', compact('coupons', 'id')));
        });
    }

    public function showCoupons()
    {
        $id = request('id');
        $limit = request('limit') ? request('limit') : 15;
        $condition = $this->getCouponCondition();
        $where = $condition[1];
        $time = $condition[0];
        $userwhere = $condition[2];

        $coupons = $this->couponRepository->getCouponsPaginated($where, $time, $userwhere, $limit);

        return LaravelAdmin::content(function (Content $content) use ($coupons, $id) {
            $content->header('领取记录');

            $content->breadcrumb(
                ['text' => '优惠券管理', 'url' => 'edu/discount/list', 'no-pjax' => 1],
                ['text' => '领取记录', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '优惠券管理']
            );
            $content->body(view('edu-backend::discount.coupon.show', compact('coupons', 'id')));
        });
    }

    private function getCouponCondition()
    {
        $time = [];
        $where = [];
        $userwhere = [];

        if ($id = request('id')) {
            $where['discount_id'] = $id;
        }

        if (!empty(request('field'))) {
            $userwhere[request('field')] = ['like', '%'.request('value').'%'];
        }

        if (!empty(request('etime')) && !empty(request('stime'))) {
            $where['created_at'] = ['<=', request('etime')];
            $time['created_at'] = ['>=', request('stime')];
        }

        if (!empty(request('etime'))) {
            $time['created_at'] = ['<=', request('etime')];
        }

        if (!empty(request('stime'))) {
            $time['created_at'] = ['>=', request('stime')];
        }

        return [$time, $where, $userwhere];
    }

    private function usedCondition()
    {
        $time = [];
        $where = [];
        $userwhere = [];
        $orderwhere = [];

        if (!empty(request('field'))) {
            if ('sn' == request('field')) {
                $orderwhere[request('field')] = ['like', '%'.request('value').'%'];
            } else {
                $userwhere[request('field')] = ['like', '%'.request('value').'%'];
            }
        }

        if (!empty(request('etime')) && !empty(request('stime'))) {
            $where['created_at'] = ['<=', request('etime')];
            $time['created_at'] = ['>=', request('stime')];
        }

        if (!empty(request('etime'))) {
            $time['created_at'] = ['<=', request('etime')];
        }

        if (!empty(request('stime'))) {
            $time['created_at'] = ['>=', request('stime')];
        }

        $orderwhere['status'] = 'paid';

        return [$time, $where, $userwhere, $orderwhere];
    }

    private function getCondition()
    {
        $where['coupon_based'] = 1;
        $where['channel'] = 'ec';
        $orWhere = [];
        $status = request('status');
        if ('nstart' == $status) {
            $where['status'] = 1;
            $where['starts_at'] = ['>', Carbon::now()];
        }

        if ('ing' == $status) {
            $where['status'] = 1;
            $where['starts_at'] = ['<=', Carbon::now()];
            $where['ends_at'] = ['>', Carbon::now()];
        }

        if ('end' == $status) {
            $where['ends_at'] = ['<', Carbon::now()];

            $orWhere['coupon_based'] = 1;
            $orWhere['status'] = 0;
        }

        if ('' != request('title')) {
            $where['title'] = ['like', '%'.request('title').'%'];
        }

        return [$where, $orWhere];
    }

    public function store(Request $request)
    {
        $base = $request->input('base');
        $rules = $request->input('rules');
        $action = $request->input('action');
        $point_action = $request->input('point-action');

        $base['label'] = $base['label'] ? $base['label'] : '';

        if (!$base['usestart_at']) {
            unset($base['usestart_at']);
        }

        $validator = $this->validationForm();
        if ($validator->fails()) {
            $warnings = $validator->messages();
            $show_warning = $warnings->first();

            return $this->ajaxJson(false, [], 404, $show_warning);
        }

        if (!$action['configuration'] and !$point_action['configuration']) {
            return $this->ajaxJson(false, [], 404, '请至少设置一种优惠动作');
        }

        try {
            DB::beginTransaction();
            if (!$discount = $this->saveData($base, $action, $rules, 1, request('agent_ids'))) {
                return $this->ajaxJson(false, [], 404, '请至少设置一种规则');
            }

            DB::commit();

            return $this->ajaxJson(true, [], 0, '');
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::info($exception);

            return $this->ajaxJson(false, [], 404, '保存失败');
        }
    }

    protected function validationForm()
    {
        $rules = [
            'base.title' => 'required',
            'base.code' => 'required',
            'base.usage_limit' => 'required | integer',
            'base.starts_at' => 'required | date',
            'base.ends_at' => 'required | date | after:base.starts_at',
        ];
        $message = [
            'required' => ':attribute 不能为空',
            'base.ends_at.after' => ':attribute 不能早于领取开始时间',
            'base.useend_at.after' => ':attribute 不能早于领取截止时间',
            'integer' => ':attribute 必须是整数',
        ];

        $attributes = [
            'base.title' => '优惠券名称',
            'base.code' => '兑换码',
            'base.usage_limit' => '发放总量',
            'base.starts_at' => '开始时间',
            'base.ends_at' => '领取截止时间',
            'base.useend_at' => '使用截止时间',
        ];

        $validator = Validator::make(
            request()->all(),
            $rules,
            $message,
            $attributes
        );

        $validator->sometimes('base.useend_at', 'required|date|after:base.ends_at', function ($input) {
            return $input->base['useend_at'] < $input->base['ends_at'];
        });

        return $validator;
    }

    public function saveData($base, $action, $rules, $coupon_base, $agent_ids = '')
    {
        if ($id = request('id')) { //修改
            $discount = Discount::find($id);
            $discount->fill($base);
            $discount->save();

            //action
            if ($actionData = DiscountAction::find(request('action_id'))) {
                if ($action['configuration']) {
                    $actionData->fill($action);
                    $actionData->save();
                } else {
                    $actionData->delete();
                }
            } elseif ($action['configuration']) {
                $action['discount_id'] = $discount->id;
                DiscountAction::create($action);
            }

            //point action
            if ($pointAction = DiscountAction::find(request('point_action_id'))) {
                if (request('point-action')['configuration']) {
                    $pointAction->fill(request('point-action'));
                    $pointAction->save();
                } else {
                    $pointAction->delete();
                }
            } elseif (request('point-action')['configuration']) {
                $addPointAction = request('point-action');
                $addPointAction['discount_id'] = $discount->id;
                DiscountAction::create($addPointAction);
            }

            //delete rules
            $discount->discountRules()->delete();
        } else {
            $base['coupon_based'] = $coupon_base;
            $discount = Discount::create($base);

            //action
            if ($action['configuration']) {
                $action['discount_id'] = $discount->id;
                DiscountAction::create($action);
            }

            if (request('point-action')['configuration']) {
                $addPointAction = request('point-action');
                $addPointAction['discount_id'] = $discount->id;
                DiscountAction::create($addPointAction);
            }
        }

        //rules
        $filterRules = $this->filterDiscountRules($rules);
        if (0 == count($filterRules)) {
            return false;
        }
        foreach ($filterRules as $key => $val) {
            $rulesData = [];
            $rulesData['discount_id'] = $discount->id;
            $rulesData['type'] = $val['type'];
            $rulesData['configuration'] = $val['value'];

            DiscountRule::create($rulesData);
        }

        return $discount;
    }

    /**
     * 过滤活动规则.
     *
     * @param $data
     *
     * @return array
     */
    public function filterDiscountRules($data)
    {
        foreach ($data as $key => $val) {
            if (!isset($val['type'])) {
                unset($data[$key]);
                continue;
            }

            if (isset($val['type']) and !is_array($val) and empty($val)) {
                unset($data[$key]);
                continue;
            }

            if ('contains_product' == $val['type'] and empty($val['value']['sku']) and empty($val['value']['spu'])) {
                unset($data[$key]);
                continue;
            }

            if ('contains_category' == $val['type'] and (!isset($val['value']['items']) || 0 == count($val['value']['items']))) {
                unset($data[$key]);
                continue;
            }

            if ('contains_shops' == $val['type'] and 0 == count($val['value']['shop_id'])) {
                unset($data[$key]);
                continue;
            }
        }

        if (0 == count($data)) {
            //return ['status' => false, 'message' => '请至少设置一种规则'];
            return [];
        }

        return $data;
    }
}
