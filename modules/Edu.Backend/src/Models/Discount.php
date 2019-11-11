<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Models;

use Carbon\Carbon;
use iBrand\Component\Discount\Models\Coupon;

class Discount extends \iBrand\Component\Discount\Models\Discount
{
    protected $appends = ['status_text'];

    public function getDiscountActionAttribute()
    {
        return $this->discountActions()->where('type', '<>', 'goods_times_point')->first();
    }

    public function getDiscountPointActionAttribute()
    {
        return $this->discountActions()->where('type', 'goods_times_point')->first();
    }

    public function getDiscountItemTotalAttribute()
    {
        return $this->discountRules()->where('type', 'item_total')->first();
    }

    public function getDiscountCartQuantityAttribute()
    {
        return $this->discountRules()->where('type', 'cart_quantity')->first();
    }

    public function getDiscountContainsProductAttribute()
    {
        return $this->discountRules()->where('type', 'contains_product')->first();
    }

    public function getDiscountContainsCategoryAttribute()
    {
        return $this->discountRules()->where('type', 'contains_category')->first();
    }

    public function getDiscountContainsRoleAttribute()
    {
        return $this->discountRules()->where('type', 'contains_role')->first();
    }

    public function getDiscountContainsShopsAttribute()
    {
        return $this->discountRules()->where('type', 'contains_shops')->first();
    }

    public function getDiscountContainsWechatGroupAttribute()
    {
        return $this->discountRules()->where('type', 'contains_wechat_group')->first();
    }

    public function getStatusTextAttribute()
    {
        $start = $this->starts_at;
        $end = $this->ends_at;
        $status = $this->status;

        if ($start > Carbon::now() and 1 == $status) {
            return '活动未开始';
        }

        if ($start <= Carbon::now() and $end > Carbon::now() and 1 == $status) {
            return '活动进行中';
        }

        if (0 == $status or $end < Carbon::now()) {
            return '活动已结束';
        }

        return '';
    }

    public function discountRules()
    {
        return $this->hasMany(DiscountRule::class, 'discount_id', 'id');
    }

    public function discountActions()
    {
        return $this->hasMany(DiscountAction::class, 'discount_id', 'id');
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'discount_id');
    }

    public function getUsedCouponCountAttribute()
    {
        return $this->coupons()->whereNotNull('used_at')->count();
    }

    public function getCountNumAttribute()
    {
        return $this->usage_limit + $this->used;
    }
}
