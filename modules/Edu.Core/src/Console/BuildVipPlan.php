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

use GuoJiangClub\Edu\Core\Models\VipPlan;
use Illuminate\Console\Command;

class BuildVipPlan extends Command
{
    protected $signature = 'ibrand:build-vip-plan';

    protected $description = 'build an vip plan.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        VipPlan::create(['title' => '666年度会员', 'price' => 66600, 'actions' => json_encode(['free_course' => 4, 'course_discount_percentage' => 70])]);
        VipPlan::create(['title' => '998年度会员', 'price' => 99800, 'actions' => json_encode(['free_course' => 8, 'course_discount_percentage' => 60])]);
        VipPlan::create(['title' => '1188年度会员', 'price' => 118800, 'actions' => json_encode(['free_course' => 12, 'course_discount_percentage' => 50])]);

        $this->info('vip plan created successfully.');
    }
}
