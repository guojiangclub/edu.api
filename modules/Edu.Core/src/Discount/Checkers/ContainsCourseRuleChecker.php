<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Discount\Checkers;

use GuoJiangClub\Edu\Core\Discount\Contracts\DiscountItemContract;
use GuoJiangClub\Edu\Core\Discount\Contracts\RuleCheckerContract;
use iBrand\Component\Discount\Contracts\DiscountContract;
use iBrand\Component\Discount\Contracts\DiscountSubjectContract;

class ContainsCourseRuleChecker implements RuleCheckerContract
{
    const TYPE = 'contains_course';

    public function isEligible(DiscountSubjectContract $subject, array $configuration, DiscountContract $discount)
    {
    }

    public function isEligibleByItem(DiscountItemContract $item, array $configuration)
    {
    }
}
