<?php

namespace iBrand\Edu\Backend\Models;

class CourseTeacher extends \iBrand\Edu\Core\Models\CourseTeacher
{
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }
}