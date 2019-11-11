<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Policies;

use GuoJiangClub\Edu\Core\Models\CourseOrder;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;

class CourseOrderPolicy
{
    use HandlesAuthorization;

    public function update(User $user, CourseOrder $order)
    {
        return $user->id == $order->user_id;
    }
}
