<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CourseChapterRepository.
 */
interface CourseChapterRepository extends RepositoryInterface
{
    public function getChaptersByCourseId($courseId);

    /**
     * get chapter number by courseId.
     *
     * @param $courseId
     *
     * @return mixed
     */
    public function getChapterCountByCourseId($courseId);

    /**
     * get course max seq by courseId.
     *
     * @param $courseId
     *
     * @return mixed
     */
    public function getChapterMaxSeqByCourseId($courseId);
}
