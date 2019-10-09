<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Repositories\Eloquent;

use iBrand\Edu\Core\Models\CourseTeacher;
use iBrand\Edu\Core\Repositories\CourseTeacherRepository;
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
