<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Services;

use GuoJiangClub\Edu\Core\Models\CourseMember;
use GuoJiangClub\Edu\Core\Repositories\CategoryRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseChapterRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseLessonRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseMemberRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseOrderRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseTeacherRepository;
use iBrand\Component\Discount\Models\Coupon;

class CourseService
{
    protected $lesson;
    protected $chapter;
    protected $teacher;
    protected $category;
    protected $course;

    protected $order;
    protected $member;

    public function __construct(CourseChapterRepository $courseChapterRepository, CourseLessonRepository $courseLessonRepository, CourseTeacherRepository $courseTeacherRepository, CategoryRepository $categoryRepository, CourseMemberRepository $courseMemberRepository, CourseOrderRepository $courseOrderRepository, CourseRepository $courseRepository)
    {
        $this->lesson = $courseLessonRepository;
        $this->chapter = $courseChapterRepository;
        $this->teacher = $courseTeacherRepository;
        $this->category = $categoryRepository;
        $this->course = $courseRepository;
        $this->order = $courseOrderRepository;
        $this->member = $courseMemberRepository;
    }

    public function getCourseItems($courseId)
    {
        $lessons = $this->lesson->getLessonsByCourseId($courseId);
        $chapters = $this->chapter->getChaptersByCourseId($courseId);

        $items = [];
        foreach ($lessons as $lesson) {
            $lesson['item_type'] = 'lesson';
            $items[] = $lesson;
        }

        foreach ($chapters as $chapter) {
            $chapter['item_type'] = 'chapter';
            $items[] = $chapter;
        }

        uasort($items, function ($item1, $item2) {
            return $item1['seq'] > $item2['seq'];
        });

        return $items;
    }

    public function getCoursesByTeacher($userId)
    {
        $courseTeachers = $this->teacher->with('course')->findByField('user_id', $userId);

        return $courseTeachers;
    }

    public function getCoursesByCategoryId($categoryId, $sort = 'created_at', $order = 'desc', $limit = 15)
    {
        $category = $this->category->find($categoryId);
        $ids = $category->children()->get(['id'])->pluck('id')->toArray();
        $ids[] = $category->id;

        return $this->course->getCoursesByCategory($ids, $sort, $order, $limit);
    }

    public function becomeStudent($order)
    {
        if (isset($order->adjustment_coupon->origin_id)) {
            Coupon::find($order->adjustment_coupon->origin_id)->setCouponUsed();
        }

        $input = ['course_id' => $order->course_id,
            'user_id' => $order->user_id,
            'order_id' => $order->id, ];

        if (!CourseMember::where($input)->first()) {
            CourseMember::create($input);

            $this->course->update([
                'student_count' => $this->member->getMemberCountByCourseIdAndRole($order->course_id),
                'income' => $this->order->sumOrderPriceByCourseId($order->course_id, ['paid', 'cancelled']),
            ], $order->course_id);

            event('edu.course.order.success.wechat.notification', $order);
        }

        return $order;
    }
}
