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
 * Interface CourseFavoriteRepository.
 */
interface CourseFavoriteRepository extends RepositoryInterface
{
    public function getFavoritesByUserId($userId, $sort = 'created_at', $order = 'desc', $limit = 15);

//    public function getFavo
}
