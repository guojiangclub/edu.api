<?php


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