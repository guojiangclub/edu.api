<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\PaidNotify;

use Carbon\Carbon;
use GuoJiangClub\Component\Pay\Contracts\PayNotifyContract;
use GuoJiangClub\Component\Pay\Models\Charge;
use GuoJiangClub\Edu\Core\Repositories\CourseOrderRepository;
use GuoJiangClub\Edu\Core\Services\CourseService;

class CoursePaidNotify implements PayNotifyContract
{
    protected $order;

    protected $courseService;

    public function __construct(CourseOrderRepository $orderRepository, CourseService $courseService)
    {
        $this->order = $orderRepository;

        $this->courseService = $courseService;
    }

    public function success(Charge $charge)
    {
        $order = $this->order->getOrderBySN($charge->order_no);

        if ($order->total == $charge->amount) {
            $order->status = 'paid';
            $order->paid_at = Carbon::now();
            $order->payment = $charge->channel;
            $order->save();

            $this->courseService->becomeStudent($order);

            return;
        }
        \Log::info('支付失败');
    }
}
