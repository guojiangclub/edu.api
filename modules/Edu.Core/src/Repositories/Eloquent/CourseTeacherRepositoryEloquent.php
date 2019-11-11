<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Repositories\Eloquent;

use GuoJiangClub\Edu\Core\Models\CourseTeacher;
use GuoJiangClub\Edu\Core\Repositories\CourseTeacherRepository;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseMemberRepositoryEloquent.
 */
class CourseTeacherRepositoryEloquent extends BaseRepository implements CourseTeacherRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseTeacher::class;
    }
}
