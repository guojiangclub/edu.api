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
 * Interface CourseLessonRepository.
 */
interface CourseLessonRepository extends RepositoryInterface
{
    public function getLessonsByCourseId($courseId);

    public function getLessonMaxSeqByCourseId($courseId);

    public function getLessonCountByCourseId($courseId);
}
