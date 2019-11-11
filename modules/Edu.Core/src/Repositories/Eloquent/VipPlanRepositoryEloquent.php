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

use GuoJiangClub\Edu\Core\Models\VipPlan;
use GuoJiangClub\Edu\Core\Repositories\VipPlanRepository;
use Prettus\Repository\Eloquent\BaseRepository;

class VipPlanRepositoryEloquent extends BaseRepository implements VipPlanRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return VipPlan::class;
    }


}
