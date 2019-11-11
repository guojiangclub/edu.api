<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Models;

//use iBrand\Component\User\Models\User;
use GuoJiangClub\Hellobi\Auth\User;

class VipOrder extends \GuoJiangClub\Edu\Core\Models\VipOrder
{
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }
}
