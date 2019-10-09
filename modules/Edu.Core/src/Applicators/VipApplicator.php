<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Applicators;

use iBrand\Component\Discount\Contracts\AdjustmentContract;
use iBrand\Component\Discount\Contracts\DiscountSubjectContract;
use iBrand\Edu\Core\Models\CourseOrderAdjustment;
use iBrand\Edu\Core\Models\VipMember;

class VipApplicator
{
    public function apply(DiscountSubjectContract $order, VipMember $vipMember, $free = false)
    {
        if (!$this->checkupFree($vipMember) && $free) {  //如果没有免费课程，但是说要使用免费，则报错
            throw new \Exception('无法使用VIP');
        }

        if ($free) {
            $discountAmount = -$order->getCurrentTotal();
        } else {
            $configuration = $vipMember->plan->actions;
            $discountAmount = $this->calculateAdjustmentAmount($order->getCurrentTotal(), $configuration['course_discount_percentage']);
        }

        $adjustment = $this->createAdjustment($vipMember, $discountAmount);
        $order->addAdjustment($adjustment);
    }

    public function calculate(DiscountSubjectContract $order, VipMember $vipMember){
        $configuration = $vipMember->plan->actions;
        $discountAmount = $this->calculateAdjustmentAmount($order->getCurrentTotal(), $configuration['course_discount_percentage']);
        $adjustment = $this->createAdjustment($vipMember, $discountAmount);
        $order->addAdjustment($adjustment);
    }

    private function createAdjustment($vipMember, $amount)
    {
        $adjustment = app(AdjustmentContract::class);

        $originType = 'vip';

        return $adjustment->createNew('vip_discount', 'VIP 会员折扣', $amount, $vipMember->id, $originType);
    }

    private function calculateAdjustmentAmount($discountSubjectTotal, $percentage)
    {
        return -1 * (int) round($discountSubjectTotal * (1 - $percentage / 100));
    }

    private function checkupFree($vipMember)
    {
        $configuration = $vipMember->plan->actions;

        $freeCount = $configuration['free_course'];

        $useCount = CourseOrderAdjustment::where('origin_type', 'vip')->where('origin_id', $vipMember->id)->whereHas('order', function ($query) {
            $query->where('status', 'paid');
        })->get()->count();

        return $useCount < $freeCount;
    }


}
