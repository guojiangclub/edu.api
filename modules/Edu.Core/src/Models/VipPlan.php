<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Models;

use GuoJiangClub\Currency\Format\HasFormatAttributesTrait;
use GuoJiangClub\Edu\Core\Discount\Contracts\DiscountItemContract;
use Illuminate\Database\Eloquent\Model;

class VipPlan extends Model implements DiscountItemContract
{
    use HasFormatAttributesTrait;
 
    protected $guarded = ['id'];

    protected $table = 'vip_plan';

    protected $format_attributes = ['price'];

    /**
     * get item type.
     *
     * @return string
     */
    public function getItemType()
    {
        return 'vip';
    }

    public function getActionsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getFreeCourseCount()
    {
        $actions = $this->actions;

        return isset($actions['free_course']) ? $actions['free_course'] : 0;
    }
}
