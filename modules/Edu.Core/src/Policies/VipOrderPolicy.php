<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-01-11
 * Time: 12:15
 */

namespace GuoJiangClub\Edu\Core\Policies;

use GuoJiangClub\Edu\Core\Models\VipOrder;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class VipOrderPolicy
{
    use HandlesAuthorization;

    public function update(User $user, VipOrder $order)
    {
        return $user->id == $order->user_id;
    }
}