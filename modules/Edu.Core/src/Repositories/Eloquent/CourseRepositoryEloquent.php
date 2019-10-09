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

use iBrand\Edu\Core\Models\Course;
use iBrand\Edu\Core\Repositories\CourseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseRepositoryEloquent.
 */
class CourseRepositoryEloquent extends BaseRepository implements CourseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Course::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * get active course by course's id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findActiveCourse($id)
    {
        if ($course = $this->find($id) and 'published' == $course->status) {
            return $course;
        }

        return null;
    }


    public function searchCourses($conditions, $sort = 'latest', $start = 0, $limit = 10)
    {
        return $this->scopeQuery(function ($query) use ($sort, $start, $limit) {
            return $query->where('status', 'published')->orderBy($sort, 'desc')->skip($start)->take($limit);
        })->findWhere($conditions);
    }


    /**
     * @param $title
     * @param string $sort
     * @param int $limit
     * @return mixed
     */
    public function searchCoursesByTitle($title, $sort = 'updated_at', $limit = 15,$status=null)
    {

        $query = $this->model;

        if (!empty($title)) {

            $query = $query->where('title', 'like', '%' . $title . '%');
        }

        if (!empty($status)) {

            $query = $query->where('status',$status);
        }

        return $query->orderBy('recommended_time', 'desc')->orderBy($sort, 'desc')->with('teacher')->paginate($limit);

    }

    /**
     * 根据分类ID获取课程列表.
     *
     * @param $categoryId
     * @param string $sort
     * @param string $order
     * @param int $limit
     *
     * @return mixed
     */
    public function getCoursesByCategory($categoryId, $sort = 'updated_at', $order = 'desc', $limit = 10)
    {
        if (empty($categoryId)) {
            return $this->scopeQuery(function ($query) use ($sort, $order) {
                return $query
                    ->where('status', 'published')
                    ->orderBy($sort, $order);
            })->with('teacher')->paginate($limit);
        }

        return $this->scopeQuery(function ($query) use ($sort, $order, $categoryId) {
            $query = $query->whereHas('categories', function ($query) use ($categoryId) {
                $query->whereIn('category_id', $categoryId);
            });

            return $query = $query
                ->where('status', 'published')
                ->orderBy($sort, $order);
        })->with('teacher')->paginate($limit);
    }

    public function getCoursesByCategoryNew($categoryId, $sort = 'updated_at', $order = 'desc', $limit = 10)
    {
        if (empty($categoryId)) {
            return $this->scopeQuery(function ($query) use ($sort, $order) {
                return $query
                    ->where('status', 'published')
                    ->orderBy($sort, $order);
            })->paginate($limit);
        }

        return $this->scopeQuery(function ($query) use ($sort, $order, $categoryId) {
            $query = $query->whereHas('categories', function ($query) use ($categoryId) {
                //$query->whereIn('category_id',$categoryId);
                foreach ($categoryId as $id) {
                    $query = $query->where('category_id', $id);
                }

                return $query;
            });

            return $query = $query
                ->where('status', 'published')
                ->orderBy($sort, $order);
        })->paginate($limit);
    }

    public function getCoursesByScope($scope, $sort = 'updated_at', $order = 'desc', $limit = 15)
    {
        return $this->scopeQuery(function ($query) use ($scope, $sort, $order) {
            return $query
                ->where($scope)
                ->orderBy($sort, $order);
        })->with('teacher')->paginate($limit);
    }

    public function getAllCourses($sort = 'updated_at', $order = 'desc', $limit = 15)
    {
        return $this->scopeQuery(function ($query) use ($sort, $order) {
            return $query
                ->where('status', 'published')
                ->orderBy($sort, $order);
        })->with('teacher')->paginate($limit);
    }

    public function getCoursesByIds(array $ids)
    {
        return $this->scopeQuery(function ($query) {
            return $query
                ->orderBy('updated_at', 'desc');
        })->findWhereIn('id', $ids);
    }

    public function getCourseCountByCategoryId($categoryId)
    {
        return $this->model->where('categoryId', $categoryId)->count();
    }

    public function gerUserCourse($id, $perPage = 15)
    {
        $course = [];
        foreach ($id as $a) {
            $course[] = $this->model->where('id', $a->courseId)->paginate($perPage);
        }

        return $course;
    }

    /**
     * get recommend courses.
     *
     * @param int $limit
     *
     * @return mixed
     */
    public function getRecommendCourses($limit = 15)
    {
        return $this->with('teacher')->orderBy('recommended_seq', 'desc')->orderBy('recommended_time', 'desc')
            ->scopeQuery(function ($query) {
                return $query->where('recommended', 1);
            })
            ->paginate($limit);
    }

    public function getDiscountCourses($limit = 15)
    {
        return $this->with('teacher')->orderBy('recommended_seq', 'desc')->orderBy('recommended_time', 'desc')
            ->scopeQuery(function ($query) {
                return $query->where('is_discount', 1);
            })
            ->paginate($limit);
    }
}
