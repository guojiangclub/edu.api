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
use iBrand\Component\Discount\Checkers\DiscountEligibilityChecker as BaseDiscountEligibilityChecker;
use iBrand\Component\Discount\Contracts\DiscountContract;

class DiscountEligibilityChecker extends BaseDiscountEligibilityChecker
{
    public function isEligibleItem(DiscountItemContract $item, DiscountContract $discount)
    {
        if (!$this->datesEligibilityChecker->isEligible($discount)) {
            return false;
        }

        if (!$this->usageLimitEligibilityChecker->isEligible($discount)) {
            return false;
        }

        if (!$discount->hasRules()) {
            return true;
        }

        //如果包含了这三种规则，则需要判断
        foreach ($discount->getRules()->whereIn('type', ['contains_category', 'contains_product']) as $rule) {
            $checker = app($rule->type);
            $configuration = json_decode($rule->configuration, true);
            if ($checker->isEligibleByItem($item, $configuration)) {
                return true;
            }

            return false;
        }

        return true;
    }
}
