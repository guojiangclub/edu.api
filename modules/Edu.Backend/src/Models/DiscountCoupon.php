<?php

namespace iBrand\Edu\Backend\Models;


class DiscountCoupon extends \iBrand\Component\Discount\Models\Coupon
{
    public function discount()
    {
        return $this->belongsTo(Discount::class,'discount_id');
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }



}