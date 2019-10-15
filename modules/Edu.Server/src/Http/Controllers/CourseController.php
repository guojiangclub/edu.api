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

use Carbon\Carbon;
use iBrand\Component\Discount\Repositories\DiscountRepository;
use iBrand\Edu\Core\Repositories\CategoryRepository;
use iBrand\Edu\Core\Repositories\CourseAnnouncementRepository;
use iBrand\Edu\Core\Repositories\CourseMemberRepository;
use iBrand\Edu\Core\Repositories\CourseRepository;
use iBrand\Edu\Core\Repositories\VipMemberRepository;
use iBrand\Edu\Core\Services\CourseService;
use iBrand\Edu\Server\Resources\Course;
use iBrand\Edu\Server\Resources\CourseAnnouncement;
use iBrand\Edu\Core\Models\CourseOrderAdjustment;
use iBrand\Component\User\Repository\UserRepository;
use iBrand\Common\Controllers\Controller;
use iBrand\Edu\Core\Models\UserDetails;

class CourseController extends Controller
{
    protected $course;
    protected $member;
    protected $discount;
    protected $vipMember;
    protected $announcement;
    protected $user;

    public function __construct(CourseRepository $courseRepository
        , CourseMemberRepository $courseMemberRepository
        , DiscountRepository $discountRepository
        , VipMemberRepository $vipMemberRepository
        , CourseAnnouncementRepository $announcementRepository
        , UserRepository $userRepository
    )
    {
        $this->course = $courseRepository;
        $this->member = $courseMemberRepository;
        $this->discount = $discountRepository;
        $this->vipMember = $vipMemberRepository;
        $this->announcement = $announcementRepository;
        $this->user = $userRepository;
    }

    public function index()
    {
        $categoryId = request('category');
        switch (request('type')) {
            case 1:
                $orderBy = 'student_count';
                break;
            case 2:
                $orderBy = 'recommended_time';
                break;
            default:
                $orderBy = 'created_at';
        }
        $category = app(CategoryRepository::class)->find($categoryId);

        if (0 == $category->level) {
            $ids = $category->children()->orderBy('weight', 'desc')->get(['id'])->pluck('id')->toArray();
            $ids[] = $category->id;
            $courses = $this->course->getCoursesByCategory($ids, $orderBy, 'desc', 15);
        } else {
            $ids[] = $category->id;
            $courses = $this->course->getCoursesByCategory($ids, $orderBy, 'desc', 15);
        }

        return $this->paginator($courses, Course::class, compact('category'))->hide(['about']);
    }

    public function show($id)
    {
        if (!$course = $this->course->findActiveCourse($id)) {
            return $this->failed('课程不存在或者未发布');
        }

        $course = $course->makeVisible('about');
        $user = auth('api')->user();

        $isMember = false;
        if ($user && $this->member->getMemberByCourseIdAndUser($id, $user->id)) {
            $isMember = true;
        }


        $isVip = false;
        $freeCourseCount = 0;

        if ($user) {
            $vipMember = $this->vipMember->getActiveByUser($user->id)->first();
            $isVip = $vipMember ? true : false;

            if ($isVip) {

                $useCount = CourseOrderAdjustment::where('origin_type', 'vip')->where('origin_id', $vipMember->id)->whereHas('order', function ($query) {
                    $query->where('status', 'paid');
                })->get()->count();

                $freeCourseCount = $vipMember->plan->getFreeCourseCount() - $useCount;

            }
        }

        $regex = "/src=\"\/uploads\/ueditor\/php\//";
        $num_matches = preg_replace($regex, 'src="' . env('HOMESITE') . '/uploads/ueditor/php/', $course->about);
        $regex = "/src=\"\/files\/course\//";
        $num_matches = preg_replace($regex, 'src="' . env('HOMESITE') . '/files/course/', $num_matches);
        $course->about = $num_matches;

        $teacher = null;
        $coterie=null;
        if ($course->teacher) {
            $teacher=$course->teacher->with('details')->where('user_id',$course->teacher->user_id)->first();
            $teacher->avatar=getHellobiAvatar($course->teacher->avatar);
            $coteries = null;
            $coterie = $coteries->total() ? $coteries->toArray()['data'][0] : null;
        }

        $coupons = $this->discount->findActive(1);

        $serverTime = Carbon::now()->toDateTimeString();

        return $this->item($course, Course::class, compact('isMember', 'isVip', 'vipMember', 'teacher',
            'coupons', 'coterie', 'serverTime', 'freeCourseCount'));
    }

    public function lessons($id)
    {
        if (!$course = $this->course->findActiveCourse($id)) {
            return $this->failed('课程不存在或者未发布');
        }

        $items = app(CourseService::class)->getCourseItems($id);

        $results = [];

        foreach ($items as $item) {
            $results[] = $item;
        }

        return $this->success($results);
    }


    public function searchCourses()
    {

        $title = request('title');

        $limit = request('limit') ? request('limit') : 15;

        $courses = $this->course->searchCoursesByTitle($title, $sort = 'updated_at', $limit,'published');

        return $this->paginator($courses, Course::class);

    }


    public function getAnnouncement($id)
    {

        $limit = request('limit') ? request('limit') : 15;

        $announcement = $this->announcement->getAnnouncementsByCourseId($id, $limit);

        return $this->paginator($announcement, CourseAnnouncement::class);

    }

}
