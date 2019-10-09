<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Models;

use Illuminate\Database\Eloquent\Model;

class VipOrder extends Model
{
    protected $guarded = ['id'];

    protected $table = 'vip_order';

    public function plan()
    {
        return $this->belongsTo(VipPlan::class);
    }
}
