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
use iBrand\Component\Pay\Contracts\PayNotifyContract;
use iBrand\Component\Pay\Models\Charge;
use GuoJiangClub\Edu\Core\Repositories\VipMemberRepository;
use GuoJiangClub\Edu\Core\Repositories\VipOrderRepository;

class VipPaidNotify implements PayNotifyContract
{
    protected $order;
    protected $member;

    public function __construct(VipOrderRepository $orderRepository, VipMemberRepository $vipMemberRepository)
    {
        $this->order = $orderRepository;

        $this->member = $vipMemberRepository;
    }

    public function success(Charge $charge)
    {
        $order = $this->order->getOrderBySN($charge->order_no);

        if ($order->price == $charge->amount) {
            $order->status = 2;

            $order->paid_at = Carbon::now();

            $order->channel = $charge->channel;

            $order->out_trade_no = $charge->out_trade_no;

            $order->transaction_no = $charge->transaction_no;

            $this->member->create(['plan_id'  => $order->plan_id, 'user_id' => $order->user_id,
                                   'order_id' => $order->id, 'joined_at' => Carbon::now(), 'deadline' => Carbon::now()->addDays($order->plan->days),]);

            $order->plan->increment('member_count', 1);

            $order->plan->save();

            $order->save();

            return;
        }

        \Log::info('支付失败');
    }
}
