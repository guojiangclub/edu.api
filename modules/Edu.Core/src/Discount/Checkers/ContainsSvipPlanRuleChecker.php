<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Discount\Checkers;

use iBrand\Component\Discount\Contracts\DiscountContract;
use iBrand\Component\Discount\Contracts\DiscountSubjectContract;
use GuoJiangClub\Edu\Core\Discount\Contracts\DiscountItemContract;
use GuoJiangClub\Edu\Core\Discount\Contracts\RuleCheckerContract;

class ContainsSvipPlanRuleChecker implements RuleCheckerContract
{
    const TYPE = 'contains_svip_plan';

    public function isEligible(DiscountSubjectContract $subject, array $configuration, DiscountContract $discount)
    {
    }

    public function isEligibleByItem(DiscountItemContract $item, array $configuration)
    {
        return false;
    }
}
