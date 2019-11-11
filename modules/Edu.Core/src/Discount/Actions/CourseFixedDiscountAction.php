<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Discount\Actions;

use iBrand\Component\Discount\Actions\DiscountAction;
use iBrand\Component\Discount\Contracts\DiscountActionContract;
use iBrand\Component\Discount\Contracts\DiscountContract;
use iBrand\Component\Discount\Contracts\DiscountSubjectContract;
use Illuminate\Support\Collection;

class CourseFixedDiscountAction extends DiscountAction implements DiscountActionContract
{
    const TYPE = 'course_order_fixed_discount';

    /**
     * @param DiscountSubjectContract $subject
     * @param array                   $configuration
     * @param DiscountContract        $discount
     *
     * @return mixed|void
     */
    public function execute(DiscountSubjectContract $subject, array $configuration, DiscountContract $discount)
    {
        $discountAmount = $this->calculateAdjustmentAmount($subject->getCurrentTotal(), $configuration['amount']);
        if (0 === $discountAmount) {
            return;
        }
        $adjustment = $this->createAdjustment($discount, $discountAmount);
        $subject->addAdjustment($adjustment);
    }

    /**
     * @param $discountSubjectTotal
     * @param $targetDiscountAmount
     *
     * @return float|int
     */
    private function calculateAdjustmentAmount($discountSubjectTotal, $targetDiscountAmount)
    {
        return -1 * min($discountSubjectTotal, $targetDiscountAmount);
    }

    /**
     * @param DiscountSubjectContract $subject
     * @param array                   $configuration
     * @param DiscountContract        $discount
     *
     * @return float|int|mixed
     */
    public function calculate(DiscountSubjectContract $subject, array $configuration, DiscountContract $discount)
    {
        $discount->adjustments = new Collection();
        $discountAmount = $this->calculateAdjustmentAmount($subject->getCurrentTotal(), $configuration['amount']);
        $discount->adjustments->push(['order_id' => $subject->id, 'amount' => $discountAmount]);
        $discount->adjustmentTotal = $discountAmount;

        return $discountAmount;
    }
}
