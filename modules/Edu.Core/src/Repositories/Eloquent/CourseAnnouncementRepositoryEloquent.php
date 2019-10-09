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

use iBrand\Edu\Core\Models\CourseAnnouncement;
use iBrand\Edu\Core\Repositories\CourseAnnouncementRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseAnnouncementRepositoryEloquent.
 */
class CourseAnnouncementRepositoryEloquent extends BaseRepository implements CourseAnnouncementRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseAnnouncement::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getAnnouncementsByCourseId($course_id, $limit = 15)
    {
        $query = $this->model;

        if (is_array($course_id)) {

            $query = $query->whereIn('course_id', $course_id);

        } else {

            $query = $query->where('course_id', $course_id);
        }

        return $query->with(['course', 'course.teacher'])
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

    }
}
