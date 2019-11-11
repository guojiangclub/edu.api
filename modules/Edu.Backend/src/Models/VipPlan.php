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

class VipPlan extends \GuoJiangClub\Edu\Core\Models\VipPlan
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
