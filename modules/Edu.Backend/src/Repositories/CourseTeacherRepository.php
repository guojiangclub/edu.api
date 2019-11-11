<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Repositories;

use GuoJiangClub\Edu\Backend\Models\CourseTeacher;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseTeacherRepository extends BaseRepository
{
    public function model()
    {
        return CourseTeacher::class;
    }
}
