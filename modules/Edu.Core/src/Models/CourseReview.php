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

use GuoJiangClub\Edu\Core\Models\Relations\BelongsToCourseTrait;
use Illuminate\Database\Eloquent\Model;

class CourseReview extends Model
{
    use BelongsToCourseTrait;

    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('ibrand.app.database.prefix', 'ibrand_').'edu_course_review');

        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id', 'uid');
    }

    public function getAddTimeAttribute()
    {
        return date('Y-m-d', strtotime($this->created_at));
    }
}
