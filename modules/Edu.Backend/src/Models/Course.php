<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/16
 * Time: 11:06
 */

namespace iBrand\Edu\Backend\Models;


use iBrand\Edu\Core\Models\CourseTeacher;

class Course extends \iBrand\Edu\Core\Models\Course
{
    public function teacher()
    {
        return $this->hasOne(CourseTeacher::class)->withDefault();
    }
}