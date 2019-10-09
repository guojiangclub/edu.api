<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/28
 * Time: 15:24
 */

namespace iBrand\Edu\Backend\Models;


class VipPlan extends \iBrand\Edu\Core\Models\VipPlan
{
    public function setActionsAttribute($value)
    {
        $this->attributes['actions'] = json_encode($value);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    public function getPriceAttribute()
    {
        return $this->attributes['price'] / 100;
    }

    public function setDiscountPriceAttribute($value)
    {
        $this->attributes['discount_price'] = $value * 100;
    }

    public function getDiscountPriceAttribute()
    {
        return $this->attributes['discount_price'] / 100;
    }

}