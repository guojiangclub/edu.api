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

use GuoJiangClub\Edu\Core\Models\VipOrder;
use GuoJiangClub\Edu\Core\Repositories\VipOrderRepository;
use Prettus\Repository\Eloquent\BaseRepository;

class VipOrderRepositoryEloquent extends BaseRepository implements VipOrderRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return VipOrder::class;
    }

    public function getOrderBySN($sn){

        return $this->with('plan')->findByField('order_no', $sn)->first();
    }

}
