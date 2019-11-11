<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Repositories\Eloquent;

use Carbon\Carbon;
use GuoJiangClub\Edu\Core\Models\VipMember;
use GuoJiangClub\Edu\Core\Repositories\VipMemberRepository;
use Prettus\Repository\Eloquent\BaseRepository;

class VipMemberRepositoryEloquent extends BaseRepository implements VipMemberRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return VipMember::class;
    }

    /**
     * get active member by user.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function getActiveByUser($userId)
    {
        return $this->with('plan')->findWhere(['user_id' => $userId, ['deadline', '>', Carbon::now()]]);
    }

}
