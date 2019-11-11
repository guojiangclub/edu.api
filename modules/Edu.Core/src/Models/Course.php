<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Models;

use GuoJiangClub\Currency\Format\HasFormatAttributesTrait;
use GuoJiangClub\Edu\Core\Discount\Contracts\DiscountItemContract;
use Illuminate\Database\Eloquent\Model;

class Course extends Model implements DiscountItemContract
{
    use HasFormatAttributesTrait;

    protected $format_attributes = ['price', 'discount_price'];

    protected $hidden = ['about'];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('ibrand.app.database.prefix', 'ibrand_').'edu_course');

        parent::__construct($attributes);
    }

    protected $guarded = ['id'];

    protected $appends = [];

    public function members()
    {
        return $this->hasMany(CourseMember::class, 'courseId');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, config('ibrand.app.database.prefix', 'ibrand_').'edu_course_category');
    }

    public function teacher()
    {
        return $this->hasOne(CourseTeacher::class);
    }

    public function getPictureAttribute($value)
    {
        if (!empty($value)) {
            $preg = '/^http(s)?:\\/\\/.+/';
            if (preg_match($preg, $value)) {
                return $value;
            }
        }

        if (empty($value)) {
            return 'https://cdn.hellobi.com/images/default/course-default-475x250.png';
        }

        $parts = explode('://', $value);
        if (empty($parts) or 2 != count($parts)) {
            return env('HOME_SITE').$value;
        }

        return env('HOME_SITE').'/uploads/'.$parts[1];
    }

    public function getIsDiscountAttribute($value)
    {
        if (0 != $value) {
            $time = $this->attributes['discount_end_time'];
            if ($time < date('Y-m-d H:i:s', time())) {
                return 0;
            }
        }

        return $value;
    }

    /**
     *return discount price.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getDiscountPriceAttribute($value)
    {
        if (!$this->is_discount) {
            return $this->price;
        }

        return $value;
    }

    /**
     * get item type.
     *
     * @return string
     */
    public function getItemType()
    {
        return 'course';
    }
}
