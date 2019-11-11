<?php

namespace GuoJiangClub\Edu\Backend\Models;


class CourseOrder extends \GuoJiangClub\Edu\Core\Models\CourseOrder
{
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }
}