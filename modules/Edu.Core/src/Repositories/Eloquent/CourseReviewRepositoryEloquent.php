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

use GuoJiangClub\Edu\Core\Models\CourseReview;
use GuoJiangClub\Edu\Core\Repositories\CourseReviewRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseReviewRepositoryEloquent.
 */
class CourseReviewRepositoryEloquent extends BaseRepository implements CourseReviewRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseReview::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getReviewsByCourseId($courseId, $limit = 10)
    {
        return $this->scopeQuery(function ($query) use ($courseId) {
            return $query->with('user')->where('courseId', $courseId)->orderBy('created_at', 'desc');
        })->paginate($limit);
    }

    /**
     * get review by course and user.
     *
     * @param $courseId
     * @param $userId
     *
     * @return mixed
     */
    public function getReviewByCourseIdAndUserId($courseId, $userId)
    {
        return $this->findWhere(['user_id' => $userId, 'courseId' => $courseId])->first();
    }

    public function getReviewRatingSumByCourseId($courseId)
    {
        return $this->model->where('courseId', $courseId)->sum('rating');
    }

    public function getReviewCountByCourseId($courseId)
    {
        return $this->model->where('courseId', $courseId)->count();
    }
}
