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

use iBrand\Component\Discount\Contracts\DiscountSubjectContract;
use iBrand\Component\User\Models\User;
use GuoJiangClub\Currency\Format\HasFormatAttributesTrait;
use GuoJiangClub\Edu\Core\Models\Relations\BelongsToCourseTrait;
use Illuminate\Database\Eloquent\Model;

class CourseOrder extends Model implements DiscountSubjectContract
{
    use BelongsToCourseTrait, HasFormatAttributesTrait;

    protected $guarded = ['id'];

    protected $format_attributes = ['total'];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('ibrand.app.database.prefix', 'ibrand_') . 'edu_course_order');

        parent::__construct($attributes);
    }

    public function save(array $options = [])
    {
        $order = parent::save($options);
        $this->adjustments()->saveMany($this->getAdjustments());

        return $order;
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function adjustments()
    {
        return $this->hasMany(CourseOrderAdjustment::class, 'order_id');
    }

    public function adjustment_coupon()
    {
        return $this->hasOne(CourseOrderAdjustment::class, 'order_id')
            ->where('type', 'order_discount')
            ->where('origin_type', 'coupon');

    }

    /**
     * get subject total amount.
     *
     * @return int
     */
    public function getSubjectTotal()
    {
        return $this->items_total;
    }

    /**
     * get subject count item.
     *
     * @return int
     */
    public function getSubjectCount()
    {
        return 1;
    }

    /**
     * get subject items.
     *
     * @return mixed
     */
    public function getItems()
    {
        return null;
    }

    /**
     * get subject count.
     *
     * @return mixed
     */
    public function countItems()
    {
        return 1;
    }

    /**
     * @param $adjustment
     *
     * @return mixed
     */
    public function addAdjustment($adjustment)
    {
        if (!$this->hasAdjustment($adjustment)) {
            $this->adjustments->add($adjustment);
            $this->addToAdjustmentsTotal($adjustment);
        }
    }

    public function hasAdjustment(CourseOrderAdjustment $adjustment)
    {
        return $this->adjustments->contains(function ($value, $key) use ($adjustment) {
            if ($adjustment->order_item_id) {
                return $adjustment->origin_type == $value->origin_type
                    and $adjustment->origin_id == $value->origin_id
                    and $adjustment->order_item_id == $value->order_item_id;
            }

            return $adjustment->origin_type == $value->origin_type
                and $adjustment->origin_id == $value->origin_id;
        });
    }

    public function getAdjustments()
    {
        return $this->adjustments;
    }

    protected function addToAdjustmentsTotal(CourseOrderAdjustment $adjustment)
    {
        $this->adjustments_total += $adjustment->amount;
        $this->recalculateTotal();
    }

    public function recalculateTotal()
    {
        $this->total = $this->items_total + $this->adjustments_total;

        if ($this->total < 0) {
            $this->total = 0;
        }
    }

    /**
     * get subject user.
     *
     * @return mixed
     */
    public function getSubjectUser()
    {
        return $this->user;
    }

    /**
     * get current total.
     *
     * @return mixed
     */
    public function getCurrentTotal()
    {
        return $this->total;
    }

    /**
     * get subject is paid.
     *
     * @return mixed
     */
    public function isPaid()
    {
        return 'paid' === $this->status;
    }
}
