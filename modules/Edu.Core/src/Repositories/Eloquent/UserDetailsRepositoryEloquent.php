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

use GuoJiangClub\Edu\Core\Models\UserDetails;
use GuoJiangClub\Edu\Core\Repositories\UserDetailsRepository;
use Prettus\Repository\Eloquent\BaseRepository;

class UserDetailsRepositoryEloquent extends BaseRepository implements UserDetailsRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return UserDetails::class;
    }

    public function findByUser($userId)
    {
        return $this->findByField('user_id', $userId)->first();
    }
}
