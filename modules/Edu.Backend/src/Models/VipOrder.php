<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/28
 * Time: 18:15
 */

namespace iBrand\Edu\Backend\Models;

//use iBrand\Component\User\Models\User;
use iBrand\Hellobi\Auth\User;

class VipOrder extends \iBrand\Edu\Core\Models\VipOrder
{
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }
}