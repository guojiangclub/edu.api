<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\PaidNotify;

use Carbon\Carbon;
use iBrand\Component\Pay\Contracts\PayNotifyContract;
use iBrand\Component\Pay\Models\Charge;
use iBrand\Edu\Core\Repositories\CourseOrderRepository;
use iBrand\Edu\Core\Services\CourseService;

class CoursePaidNotify implements PayNotifyContract
{
    protected $order;

    protected $courseService;

    public function __construct(CourseOrderRepository $orderRepository,CourseService $courseService)
    {
        $this->order = $orderRepository;

        $this->courseService=$courseService;

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
