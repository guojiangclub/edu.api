<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/16
 * Time: 11:06
 */

namespace GuoJiangClub\Edu\Backend\Models;


use GuoJiangClub\Edu\Core\Models\CourseTeacher;

class Course extends \GuoJiangClub\Edu\Core\Models\Course
{
    public function teacher()
    {
        return $this->hasOne(CourseTeacher::class)->withDefault();
    }
}