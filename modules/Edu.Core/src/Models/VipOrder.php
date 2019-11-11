<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Models;

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
