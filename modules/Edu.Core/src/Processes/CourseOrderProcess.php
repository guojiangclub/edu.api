<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Processes;

use Carbon\Carbon;
use GuoJiangClub\Edu\Core\Models\CourseOrder;
use GuoJiangClub\Edu\Core\Repositories\CourseMemberRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseOrderRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseRepository;

class CourseOrderProcess
{
    protected $course;
    protected $member;
    protected $order;

    public function __construct(
        CourseOrderRepository $orderRepository, CourseMemberRepository $memberRepository, CourseRepository $courseRepository)
    {
        $this->member = $memberRepository;
        $this->order = $orderRepository;
        $this->course = $courseRepository;
    }

    public function paid(CourseOrder $order)
    {
        $order = $this->order->update(['status' => 'paid', 'paid_at' => Carbon::now()], $order->id);

        $this->member->create(['course_id' => $order->course_id, 'user_id' => $order->user_id, 'order_id' => $order->id]);

        $this->course->update([
            'student_count' => $this->member->getMemberCountByCourseIdAndRole($order->course_id),
            'income' => $this->order->sumOrderPriceByCourseId($order->course_id, ['paid', 'cancelled']),
        ], $order->course_id);

        event('edu.course.order.success.wechat.notification', $order);

        return $order;
    }
}
