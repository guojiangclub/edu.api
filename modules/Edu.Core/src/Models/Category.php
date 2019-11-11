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

use Gzero\EloquentTree\Model\Tree;

class Category extends Tree
{
    protected $guarded = ['id'];

    public $timestamps = false;

    protected $appends = ['short_name'];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('ibrand.app.database.prefix', 'ibrand_') . 'edu_category');

        parent::__construct($attributes);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, config('ibrand.app.database.prefix', 'ibrand_') . 'edu_course_category');
    }

    public function getShortNameAttribute()
    {
        return mb_substr($this->name, 0, 4);
    }
}
