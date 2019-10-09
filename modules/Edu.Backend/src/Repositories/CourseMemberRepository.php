<?php


namespace iBrand\Edu\Backend\Repositories;

use iBrand\Edu\Backend\Models\CourseMember;
use Prettus\Repository\Eloquent\BaseRepository;


class CourseMemberRepository extends BaseRepository
{
    public function model()
    {
        return CourseMember::class;
    }

}