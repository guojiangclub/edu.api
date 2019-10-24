<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Services;


use Exception;
use Carbon\Carbon;
use iBrand\Component\Discount\Applicators\DiscountApplicator;
use iBrand\Component\Discount\Checkers\CouponEligibilityChecker;
use iBrand\Component\Discount\Checkers\DatesEligibilityChecker;
use iBrand\Component\Discount\Contracts\DiscountSubjectContract;
use iBrand\Component\Discount\Models\Coupon;
use iBrand\Component\Discount\Models\Discount;
use iBrand\Component\Discount\Repositories\CouponRepository;
use iBrand\Component\Discount\Repositories\DiscountRepository;
use iBrand\Edu\Core\Discount\Checkers\DiscountEligibilityChecker;
use iBrand\Edu\Core\Discount\Contracts\DiscountItemContract;

class DiscountService
{
    private $discountRepository;
    private $discountChecker;
    private $couponChecker;
    private $couponRepository;
    protected $applicator;
    protected $datesEligibilityChecker;

    public function __construct(DiscountRepository $discountRepository, DiscountEligibilityChecker $discountEligibilityChecker, CouponRepository $couponRepository, CouponEligibilityChecker $couponEligibilityChecker, DiscountApplicator $discountApplicator, DatesEligibilityChecker $datesEligibilityChecker)
    {
        $this->discountRepository = $discountRepository;
        $this->discountChecker = $discountEligibilityChecker;
        $this->couponRepository = $couponRepository;
        $this->couponChecker = $couponEligibilityChecker;
        $this->applicator = $discountApplicator;
        $this->datesEligibilityChecker = $datesEligibilityChecker;
    }

    public function getEligibilityDiscounts(DiscountSubjectContract $subject)
    {
        try {
            $discounts = $this->discountRepository->findActive(0);
            if (0 == count($discounts)) {
                return false;
            }

            $filtered = $discounts->filter(function ($item) use ($subject) {
                return $this->discountChecker->isEligible($subject, $item);
            });

            if (0 == count($filtered)) {
                return false;
            }

            foreach ($filtered as $item) {
                $this->applicator->calculate($subject, $item);
            }

            return $filtered;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getEligibilityCoupons(DiscountSubjectContract $subject, $userId)
    {
        try {
            $coupons = $this->couponRepository->findActiveByUser($userId, false);
            if (0 == count($coupons)) {
                return false;
            }

            $filtered = $coupons->filter(function ($item) use ($subject) {
                return $this->couponChecker->isEligible($subject, $item);
            });

            if (0 == count($filtered)) {
                return false;
            }

            foreach ($filtered as $item) {
                $this->applicator->calculate($subject, $item);
            }

            return $filtered;
        } catch (Exception $e) {
            return false;
        }
    }

    public function checkDiscount(DiscountSubjectContract $subject, Discount $discount)
    {
        return $this->discountChecker->isEligible($subject, $discount);
    }

    public function checkCoupon(DiscountSubjectContract $subject, Coupon $coupon)
    {
        return $this->couponChecker->isEligible($subject, $coupon);
    }

    public function getDiscountsByGoods(DiscountItemContract $discountItemContract)
    {
        $discounts = $this->discountRepository->findActive(2);
        $discounts = $discounts->filter(function ($item) use ($discountItemContract) {
            return $this->discountChecker->isEligibleItem($discountItemContract, $item);
        });

        return $discounts;
    }

    public function getCouponConvert($couponCode, $user_id)
    {

        $discount = $this->getCouponByCode($couponCode, $user_id);
        if (!$discount) {
            $coupon['error']='该优惠券码不存';
        }
        if ($discount->has_get) {
            $coupon['error']='您已经领取过该优惠券';
        }
        if ($discount->has_max) {
            $coupon['error']='该优惠券已领完库存不足';
        }

        $coupon = $this->getCouponsByUserID($user_id, $discount);

        return $coupon;

    }

    public function getCouponByCode($coupon_code, $user_id)
    {
        $query = Discount::where('status', 1)->where('coupon_based', 1)->where('code', $coupon_code);

        $data = $query
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere(function ($query) {
                        $query->where('starts_at', '<', Carbon::now());
                    });
            })
            ->where(function ($query) {
                $query->whereNull('ends_at')
                    ->orWhere(function ($query) {
                        $query->where('ends_at', '>', Carbon::now());
                    });
            })
            ->first();


        if (!$data) return null;

        $coupon_data = Coupon::where('discount_id', $data->id);

        $coupon = $coupon_data->where('user_id', $user_id)->count();

        $coupons = $coupon_data->count();

        if ($coupon >= $data->per_usage_limit) {

            $data->has_get = true;
        }

        if ($data->usage_limit <= 0 || $coupons >= $data->usage_limit) {

            $data->has_max = true;
        }

        return $data;
    }

    public function getCouponsByUserID($user_id, $discount)
    {
        if (!isset($discount->usage_limit) || $discount->usage_limit < 1) return false;

        $input['user_id'] = $user_id;
        $input['discount_id'] = $discount->id;

        if ($discount->useend_at) {
            $input['expires_at'] = $discount->useend_at;
        } else {
            $input['expires_at'] = $discount->ends_at;
        }

        $input['code'] = build_order_no('C');

        $coupon = $this->couponRepository->create($input);

        if ($coupon) {

            Discount::where(['id' => $discount->id])->decrement('usage_limit');

            Discount::where(['id' => $discount->id])->increment('used');

            return $coupon;

        }

        return false;
    }
}
