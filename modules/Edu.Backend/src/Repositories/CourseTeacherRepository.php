<?php


namespace iBrand\Edu\Backend\Repositories;

use iBrand\Edu\Backend\Models\CourseTeacher;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseTeacherRepository extends BaseRepository
{
    public function model()
    {
        return CourseTeacher::class;
    }
}