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

use iBrand\Edu\Core\Models\UserDetails;
use iBrand\Edu\Core\Repositories\UserDetailsRepository;
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
