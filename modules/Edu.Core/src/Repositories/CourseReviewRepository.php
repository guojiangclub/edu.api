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
 * Interface CourseReviewRepository.
 */
interface CourseReviewRepository extends RepositoryInterface
{
    public function getReviewsByCourseId($courseId, $limit = 10);

    /**
     * get review by course and user.
     *
     * @param $courseId
     * @param $userId
     *
     * @return mixed
     */
    public function getReviewByCourseIdAndUserId($courseId, $userId);

    public function getReviewRatingSumByCourseId($courseId);

    public function getReviewCountByCourseId($courseId);
}
