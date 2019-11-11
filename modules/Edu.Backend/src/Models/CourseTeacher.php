<?php

namespace GuoJiangClub\Edu\Backend\Models;

class CourseTeacher extends \GuoJiangClub\Edu\Core\Models\CourseTeacher
{
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }
}