<?php


namespace GuoJiangClub\Edu\Backend\Repositories;

use GuoJiangClub\Edu\Backend\Models\CourseTeacher;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseTeacherRepository extends BaseRepository
{
    public function model()
    {
        return CourseTeacher::class;
    }
}