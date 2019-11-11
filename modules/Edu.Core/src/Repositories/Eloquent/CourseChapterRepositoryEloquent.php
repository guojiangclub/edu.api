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

use GuoJiangClub\Edu\Core\Models\CourseChapter;
use GuoJiangClub\Edu\Core\Repositories\CourseChapterRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseChapterRepositoryEloquent.
 */
class CourseChapterRepositoryEloquent extends BaseRepository implements CourseChapterRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseChapter::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getChaptersByCourseId($courseId)
    {
        return $this->scopeQuery(function ($query) {
            return $query->orderBy('seq', 'asc');
        })->findByField('course_id', $courseId);
    }

    /**
     * get chapter number by courseId.
     *
     * @param $courseId
     *
     * @return mixed
     */
    public function getChapterCountByCourseId($courseId)
    {
        return $this->findByField('course_id', $courseId)->count();
    }

    /**
     * get course max seq by courseId.
     *
     * @param $courseId
     *
     * @return mixed
     */
    public function getChapterMaxSeqByCourseId($courseId)
    {
        return CourseChapter::where('course_id', $courseId)->max('seq');
    }
}
