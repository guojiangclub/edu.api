<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Server\Http\Controllers;

use iBrand\Component\Discount\Repositories\CouponRepository;
use iBrand\Component\Discount\Repositories\DiscountRepository;
use iBrand\Common\Controllers\Controller;
use iBrand\Edu\Core\Services\DiscountService;

class CouponController extends Controller
{
    private $couponRepository;
    private $discountRepository;
    private $discountService;

    public function __construct(
        CouponRepository $couponRepository, DiscountRepository $discountRepository,DiscountService $discountService
    ) {
        $this->couponRepository = $couponRepository;
        $this->discountRepository = $discountRepository;
        $this->discountService=$discountService;
    }

    public function create()
    {
        $ruleTypes = request('rule_types');
        $ruleValues = request('rule_values');

        if (!is_array($ruleTypes) || !is_array($ruleValues)) {
            return $this->failed('规则参数需要是数组');
        }

        $rules = [];
        foreach ($ruleTypes as $key => $ruleType) {
            $rules[$key] = ['type' => $ruleType, 'configuration' => $this->buildRuleConfiguration($ruleType, $ruleValues[$key])];
        }
        $discount = $this->discountRepository->create(request()->except('rule_types', 'rule_values', 'action_type', 'action_value'));

        $actionType = request('action_type');

        if (str_contains($actionType,'fixed')) {
            $actionData = ['amount' => request('action_value')];
        } else {
            $actionData = ['percentage' => request('action_value')];
        }

        $discount->rules()->createMany($rules);
        $discount->actions()->create(['type' => $actionType, 'configuration' => json_encode($actionData)]);

        return $this->success();
    }

    protected function buildRuleConfiguration($type, $value)
    {
        if ('item_total' == $type) {
            return json_encode(['amount' => $value]);
        }
        if ('contains_course' == $type) {
            return json_encode(['course' => explode(',', $value)]);
        }
    }

    public function take()
    {
        $discount = $this->discountRepository->find(request('discount_id'));

        if (!$discount->coupon_based) {
            return $this->failed('非优惠券，无法领取');
        }

        $coupon=$this->discountService->getCouponConvert($discount->code,request()->user()->id);

        return $this->success($coupon);
    }
}
