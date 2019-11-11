<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CourseAnnouncementRepository.
 */
interface CourseAnnouncementRepository extends RepositoryInterface
{
    public function getAnnouncementsByCourseId($course_id,$limit=15);
}
