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

use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use GuoJiangClub\Edu\Backend\Repositories\CourseOrderRepository;
use iBrand\Backend\Http\Controllers\Controller;

class CourseOrderController extends Controller
{
    protected $courseOrderRepository;

    public function __construct(CourseOrderRepository $courseOrderRepository)
    {
        $this->courseOrderRepository = $courseOrderRepository;
    }

    public function index()
    {
        $conditions = $this->conditions();
        $where = $conditions[0];
        $userwhere = $conditions[1];
        $coursewhere = $conditions[2];

        $orders = $this->courseOrderRepository->getOrdersPaginate($where, $userwhere, $coursewhere);

        return LaravelAdmin::content(function (Content $content) use ($orders) {
            $content->header('订单管理');

            $content->breadcrumb(
                ['text' => '订单管理', 'url' => '', 'no-pjax' => 1],
                ['text' => '订单列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '订单管理']
            );

            $content->body(view('edu-backend::course_order.index', compact('orders')));
        });
    }

    public function show($id)
    {
        $order = $this->courseOrderRepository->find($id);

        return LaravelAdmin::content(function (Content $content) use ($order) {
            $content->header('订单管理');

            $content->breadcrumb(
                ['text' => '订单管理', 'url' => '', 'no-pjax' => 1],
                ['text' => '查看订单', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '订单管理']
            );
            $payment = '';
            switch ($order->payment) {
                case 'alipay_wap':
                case 'alipay_pc_direct':
                    $payment = '支付宝支付';
                    break;
                case 'wx_pub':
                case 'wx_pub_qr':
                case 'wx_lite':
                    $payment = '微信支付';
                    break;
                default:
                    $payment = '其他';
            }

            $content->body(view('edu-backend::course_order.show', compact('order', 'payment')));
        });
    }

    protected function conditions()
    {
        $where = [];
        $userwhere = [];
        $coursewhere = [];
        if (request('course_id')) {
            $where['course_id'] = request('course_id');
        }
        if (request('status')) {
            $where['status'] = request('status');
        }

        if (!empty(request('field'))) {
            if ('title' == request('field')) {
                $coursewhere[request('field')] = ['like', '%'.request('value').'%'];
            } elseif ('sn' == request('field')) {
                $where[request('field')] = ['like', '%'.request('value').'%'];
            } else {
                $userwhere[request('field')] = ['like', '%'.request('value').'%'];
            }
        }

        return [$where, $userwhere, $coursewhere];
    }
}
