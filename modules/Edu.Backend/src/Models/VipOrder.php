<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/28
 * Time: 18:15
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