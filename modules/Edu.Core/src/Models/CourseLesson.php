<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Models;

use iBrand\Edu\Core\Models\Relations\BelongsToCourseTrait;
use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    use BelongsToCourseTrait;

    protected $guarded = ['id'];

    protected $touches = ['course'];

    protected $appends = ['length_min'];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('ibrand.app.database.prefix', 'ibrand_').'edu_course_lesson');

        parent::__construct($attributes);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'courseId');
    }

    public function getLengthMinAttribute()
    {
        return gmstrftime('%M:%S', $this->length);
    }

    public function getLinkAttribute()
    {
        if ('live' == $this->type) {
            return route('edu.live.show', ['courseId' => $this->courseId, 'lessonId' => $this->id]);
        }

        return route('edu.course.play.lesson', ['courseId' => $this->courseId, 'lessonId' => $this->id]);
    }

    public function getRtmpUrlAttribute()
    {
        $url = str_replace('http', 'rtmp', $this->mediaUri);
        $url = str_replace('hlsplay', 'lssplay', $url);
        $url = str_replace('.m3u8', '', $url);

        return $url;
    }

    public function getHlsUrlAttribute()
    {
        return $this->mediaUri;
    }

    public function getMediaUriAttribute($value)
    {
        if (env('SECURE')) {
            $value = str_replace('http', 'https', $value);
        }

        return $value;
    }

    /*public function getLivePicAttribute()
    {
        if($this->courseId==109)
            return url('images/edu/live/hadoop.jpg');
        if($this->courseId==110)
            return url('images/edu/live/python.jpg');
        if($this->courseId==183)
            return url('images/edu/live/charge.png');
        if($this->courseId==117){
            if(get_setting('course_live_picture')){
                return get_setting('course_live_picture');
            }
            return url('images/edu/live/free.png');

        }
        if($this->courseId==144)
            return url('images/edu/live/python2.jpg');
        if($this->courseId==186)
            return url('images/edu/live/kenny.jpg');
        if($this->courseId==187)
            return url('images/edu/live/zhangbin.jpg');
        return url('images/edu/live/python.jpg');
    }*/
}
