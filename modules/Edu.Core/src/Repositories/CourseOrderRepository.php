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
 * Interface CourseOrderRepository.
 */
interface CourseOrderRepository extends RepositoryInterface
{
    public function sumOrderPriceByCourseId($courseId, array $statuses);

    public function getOrderBySN($sn);
}
