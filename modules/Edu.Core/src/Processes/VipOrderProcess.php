<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Processes;

use Carbon\Carbon;
use GuoJiangClub\Edu\Core\Models\VipOrder;
use GuoJiangClub\Edu\Core\Repositories\VipMemberRepository;
use GuoJiangClub\Edu\Core\Repositories\VipOrderRepository;

class VipOrderProcess
{
    protected $member;
    protected $order;

    public function __construct(
        VipMemberRepository $vipMemberRepository, VipOrderRepository $vipOrderRepository)
    {
        $this->member = $vipMemberRepository;
        $this->order = $vipOrderRepository;
    }

    public function paid(VipOrder $order)
    {
        $order = $order->with('plan')->first();

        $order->status = 2;

        $order->paid_at = Carbon::now();

        $this->member->create(['plan_id' => $order->plan_id, 'user_id' => $order->user_id,
            'order_id' => $order->id, 'joined_at' => Carbon::now(), 'deadline' => Carbon::now()->addDays($order->plan->days), ]);

        $order->plan->increment('member_count', 1);

        $order->plan->save();

        $order->save();

        return $order;
    }
}
