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

use GuoJiangClub\Edu\Core\Models\CourseOrder;
use GuoJiangClub\Edu\Core\Repositories\CourseOrderRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseOrderRepositoryEloquent.
 */
class CourseOrderRepositoryEloquent extends BaseRepository implements CourseOrderRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseOrder::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function sumOrderPriceByCourseId($courseId, array $statuses)
    {
        /* return $this->scopeQuery(function ($query) use ($courseId) {
             return $query->where('courseId', $courseId);
         })->findWhereIn('status', $statuses)->sum('price');*/
        return CourseOrder::where('course_id', $courseId)->where('status', $statuses)->sum('total');
    }

    public function getOrderBySN($sn)
    {
        return $this->with(['course', 'course.teacher', 'adjustment_coupon'])->findByField('sn', $sn)->first();
    }
}
