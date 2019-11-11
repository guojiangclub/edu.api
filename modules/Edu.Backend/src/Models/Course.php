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

use GuoJiangClub\Edu\Core\Models\CourseTeacher;

class Course extends \GuoJiangClub\Edu\Core\Models\Course
{
    public function teacher()
    {
        return $this->hasOne(CourseTeacher::class)->withDefault();
    }
}
