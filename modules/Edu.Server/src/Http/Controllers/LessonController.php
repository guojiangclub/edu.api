<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Server\Http\Controllers;

use AliyunVod;
use iBrand\Edu\Core\Repositories\CourseLessonRepository;
use iBrand\Edu\Core\Repositories\CourseMemberRepository;
use iBrand\Common\Controllers\Controller;

class LessonController extends Controller
{
    protected $lesson;
    protected $member;

    public function __construct(CourseLessonRepository $lessonRepository, CourseMemberRepository $memberRepository)
    {
        $this->lesson = $lessonRepository;
        $this->member = $memberRepository;
    }

    public function show($id)
    {
        $user = request()->user();

        $lesson = $this->lesson->find($id);

        $vod=null;

        $vod_auth=null;

        if(!empty($lesson->media_id)){

            $play=AliyunVod::getPlayInfo($lesson->media_id);

            if(!isset($play['errorMessage'])){

                $vod=$play->toArray();
            }

            $play_auth=AliyunVod::getVideoPlayAuth($lesson->media_id);

            if(!isset($play_auth['errorMessage'])){

                $vod_auth=$play_auth->toArray();
            }
        }

        $lesson->vod=$vod;

        $lesson->vod_auth=$vod_auth;

        if ($lesson->free) {
            return $this->success($lesson);
        }

        $member = $this->member->getMemberByCourseIdAndUser($lesson->course_id, $user->id);

        if (!$member) {
            return $this->failed('您还不是该课程的学员，请先购买加入学习');
        }


        return $this->success($lesson);
    }
}
