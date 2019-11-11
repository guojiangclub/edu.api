<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Server\Http\Controllers;

use GuoJiangClub\Common\Controllers\Controller;
use GuoJiangClub\Edu\Core\Repositories\CourseAnnouncementRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseMemberRepository;
use GuoJiangClub\Edu\Server\Resources\CourseAnnouncement;
use GuoJiangClub\Edu\Server\Resources\CourseMember;

class MyCourseController extends Controller
{
    protected $member;

    protected $announcement;

    public function __construct(CourseMemberRepository $memberRepository, CourseAnnouncementRepository $courseAnnouncementRepository)
    {
        $this->member = $memberRepository;

        $this->announcement = $courseAnnouncementRepository;
    }

    public function index()
    {
        $user = request()->user();

        $members = $this->member->getMembersByUser($user->id);

        return $this->paginator($members, CourseMember::class);
    }

    public function getCoursesAnnouncement()
    {
        $user = request()->user();

        $limit = request('limit') ? request('limit') : 15;

        $CourseIds = $this->member->getAllCourseIdsByUser($user->id);

        $announcements = $this->announcement->getAnnouncementsByCourseId($CourseIds, $limit);

        return $this->paginator($announcements, CourseAnnouncement::class);
    }
}
