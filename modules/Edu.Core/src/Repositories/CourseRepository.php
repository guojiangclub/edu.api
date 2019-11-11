<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CourseRepository.
 */
interface CourseRepository extends RepositoryInterface
{
    /**
     * get recommend courses.
     *
     * @param int $limit
     *
     * @return mixed
     */
    public function getRecommendCourses($limit = 15);

    /**
     * get active course by course's id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findActiveCourse($id);

    public function searchCoursesByTitle($title, $sort = 'updated_at', $limit = 15, $status = null);

    public function searchCourses($conditions, $sort = 'latest', $start = 0, $limit = 15);

    public function getCoursesByCategory($categoryId, $sort = 'updated_at', $order = 'desc', $limit = 15);

    public function getCoursesByScope($scope, $sort = 'updated_at', $order = 'desc', $limit = 15);

    public function getAllCourses($sort = 'updated_at', $order = 'desc', $limit = 15);

    public function getCoursesByIds(array $ids);

    public function getCourseCountByCategoryId($categoryId);

    public function getCoursesByCategoryNew($categoryId, $sort = 'updated_at', $order = 'desc', $limit = 10);

    public function gerUserCourse($id, $perPage = 15);

    public function getDiscountCourses($limit = 15);
}
