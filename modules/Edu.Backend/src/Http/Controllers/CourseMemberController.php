<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Http\Controllers;

use DB;
use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use GuoJiangClub\Edu\Backend\Repositories\CourseRepository;
use GuoJiangClub\Edu\Backend\Repositories\UserRepository;
use GuoJiangClub\Edu\Core\Models\CourseMember;
use GuoJiangClub\Edu\Core\Repositories\CourseMemberRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseOrderRepository;
use iBrand\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseMemberController extends Controller
{
    protected $courseRepository;

    protected $courseMemberRepository;

    protected $userRepository;

    protected $courseOrderRepository;

    public function __construct(CourseRepository $courseRepository,
                                courseMemberRepository $courseMemberRepository,
                                UserRepository $userRepository, CourseOrderRepository $courseOrderRepository
    ) {
        $this->courseRepository = $courseRepository;

        $this->courseMemberRepository = $courseMemberRepository;

        $this->userRepository = $userRepository;

        $this->courseOrderRepository = $courseOrderRepository;
    }

    public function index($id)
    {
        $course = $this->courseRepository->find($id);

        $students = $this->courseMemberRepository->getStudentsByCourseId($id);

        return LaravelAdmin::content(function (Content $content) use ($students, $course) {
            $content->header('学员管理');

            $content->breadcrumb(
                ['text' => '所有课程', 'url' => 'edu/course/list', 'no-pjax' => 1],
                ['text' => '学员管理', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '所有课程']
            );

            $content->body(view('edu-backend::member.index', compact('course', 'students')));
        });
    }

    public function remove($id, $memberId)
    {
        $this->courseMemberRepository->delete($memberId);

        $this->courseRepository->update([
            'student_count' => $this->courseMemberRepository->getMemberCountByCourseIdAndRole($id),
        ], $id);

        return $this->ajaxJson();
    }

    public function create($id)
    {
        $course = $this->courseRepository->find($id);

        return view('edu-backend::member.create-modal', compact('course'));
    }

    public function store($id)
    {
        try {
            DB::beginTransaction();

            $nickname = request('nickname');

            $course = $this->courseRepository->find($id);

            $price = request('price');

            $remark = request('remark');

            $user = $this->userRepository->findWhere(['mobile'=>$nickname])->first();

            $member = $this->courseMemberRepository->getMemberByCourseIdAndUser($id, $user->id);

            if ($member) {
                return $this->ajaxJson(false, [], 404, '该用户已经加入课程');
            }

            if (!$user) {
                return $this->ajaxJson(false, [], 404, '该用户不存在');
            }

            $order = $this->courseOrderRepository->findWhere(['user_id' => $user->id, 'course_id' => $course->id, 'status' => 'paid'])->first();

            if (!$order) {
                $note = '管理员:'.auth('admin')->user()->username.'后台添加课程订单';

                $order = $this->courseOrderRepository->create(['sn' => build_order_no('E'), 'status' => 'paid', 'course_id' => $id,
                    'items_total' => $price, 'total' => $price, 'user_id' => $user->id, 'title' => $course->title, 'note' => $note, ]);
            }

            $member = CourseMember::firstOrNew(['course_id' => $order->course_id,
                'user_id' => $order->user_id,
                'order_id' => $order->id, ]);

            $member->remark = $remark ? $remark : '';

            $member->save();

            $this->courseRepository->update([
                'student_count' => $this->courseMemberRepository->getMemberCountByCourseIdAndRole($id),
            ], $id);

            DB::commit();

            return $this->ajaxJson(true);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->ajaxJson(false, 400, '保存失败');
        }
    }
}
