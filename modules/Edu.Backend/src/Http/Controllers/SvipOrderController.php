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
use GuoJiangClub\Edu\Backend\Repositories\VipOrderRepository;
use iBrand\Backend\Http\Controllers\Controller;

class SvipOrderController extends Controller
{
    protected $vipOrderRepository;

    public function __construct(VipOrderRepository $vipOrderRepository)
    {
        $this->vipOrderRepository = $vipOrderRepository;
    }

    public function index()
    {
        $conditions = $this->conditions();
        $where = $conditions[0];
        $andWhere = $conditions[1];

        $orders = $this->vipOrderRepository->getOrdersPaginate($where, $andWhere);

        return LaravelAdmin::content(function (Content $content) use ($orders) {
            $content->header('SVIP订单管理');

            $content->breadcrumb(
                ['text' => 'SVIP订单管理', 'url' => '', 'no-pjax' => 1],
                ['text' => 'SVIP订单列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => 'SVIP订单管理']
            );

            $content->body(view('edu-backend::vip_order.index', compact('orders')));
        });
    }

    protected function conditions()
    {
        $where = [];
        $andWhere = [];
        if (request('plan_id')) {
            $where['plan_id'] = request('plan_id');
        }

        if (request('status')) {
            $where['status'] = request('status');
        }

        if (request('user_name')) {
            $andWhere['user_name'] = ['like', '%'.request('user_name').'%'];
        }

        return [$where, $andWhere];
    }

    public function show($id)
    {
        $order = $this->vipOrderRepository->find($id);

        return LaravelAdmin::content(function (Content $content) use ($order) {
            $content->header('SVIP订单管理');

            $content->breadcrumb(
                ['text' => 'SVIP订单管理', 'url' => '', 'no-pjax' => 1],
                ['text' => '查看SVIP订单', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => 'SVIP订单管理']
            );

            $content->body(view('edu-backend::vip_order.show', compact('order')));
        });
    }
}
