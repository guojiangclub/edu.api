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

use iBrand\Component\Discount\Contracts\AdjustmentContract;
use Illuminate\Database\Eloquent\Model;

class CourseOrderAdjustment extends Model implements AdjustmentContract
{
    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('ibrand.app.database.prefix', 'ibrand_').'edu_course_order_adjustment');
        parent::__construct($attributes);
    }

    public function order()
    {
        return $this->belongsTo(CourseOrder::class);
    }

    /**
     * create a adjustment.
     *
     * @param $type
     * @param $label
     * @param $amount
     * @param $originId
     * @param $originType
     *
     * @return mixed
     */
    public function createNew($type, $label, $amount, $originId, $originType)
    {
        return new self(['type' => $type, 'label' => $label, 'amount' => $amount, 'origin_id' => $originId, 'origin_type' => $originType]);
    }
}
