<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Console;

use Carbon\Carbon;
use GuoJiangClub\Edu\Core\Models\VipMember;
use GuoJiangClub\Edu\Core\Models\VipOrder;
use Illuminate\Console\Command;

class SetUserVip extends Command
{
    protected $signature = 'ibrand:set-vip-plan';

    protected $description = 'build an vip plan.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->ask('set user id');
        $planId = $this->ask('set vip plan id');

        $order = VipOrder::create(['order_no' => build_order_no('V'), 'plan_id' => $planId, 'user_id' => $userId, 'channel' => 'test', 'paid_at' => Carbon::now(), 'price' => 1]);
        $member = VipMember::create(['plan_id' => $planId, 'user_id' => $userId, 'order_id' => $order->id, 'joined_at' => Carbon::now(), 'deadline' => Carbon::now()->addDays(365)]);
    }
}
