<?php

namespace iBrand\Edu\Backend\Models;


class CourseOrder extends \iBrand\Edu\Core\Models\CourseOrder
{
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }
}