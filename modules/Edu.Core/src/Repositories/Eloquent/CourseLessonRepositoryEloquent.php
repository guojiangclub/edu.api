<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Repositories\Eloquent;

use GuoJiangClub\Edu\Core\Models\CourseLesson;
use GuoJiangClub\Edu\Core\Repositories\CourseLessonRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseLessonRepositoryEloquent.
 */
class CourseLessonRepositoryEloquent extends BaseRepository implements CourseLessonRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseLesson::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 获取所有已发布的课时.
     *
     * @param $courseId
     *
     * @return mixed
     */
    public function getLessonsByCourseId($courseId)
    {
        return $this->orderBy('seq', 'asc')->findWhere(['course_id' => $courseId, 'status' => 1]);
    }

    public function getLessonMaxSeqByCourseId($courseId)
    {
        return CourseLesson::where('course_id', $courseId)->max('seq');
    }

    public function getLessonCountByCourseId($courseId)
    {
        return CourseLesson::where('course_id', $courseId)->count();
    }
}
