<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Repositories;

use GuoJiangClub\Edu\Backend\Models\CourseMember;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseMemberRepository extends BaseRepository
{
    public function model()
    {
        return CourseMember::class;
    }
}
