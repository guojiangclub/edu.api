<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CourseMemberRepository.
 */
interface CourseMemberRepository extends RepositoryInterface
{
    public function getCourseTeachersByCourseId($courseId);

    public function getMemberByCourseIdAndUser($courseId, $userId);

    public function getMemberCountByCourseIdAndRole($courseId, $role = 'student');

    public function getMembersMyUserIdAndRoleAndIsLearned($userId, $role = 'student', $isLearned = false, $sort = 'created_at', $order = 'desc', $limit = 15);

    public function isCourseTeacher($courseId, $user_id);

    public function getMembersByTeacher($teacherId, $sort = 'created_at', $order = 'desc', $limit = 15);

    public function getStudentsByCourseId($courseId, $limit = 20);

    public function getAllStudentsByCourseId($courseId);

    public function getCourseVisibleTeacher($courseId);

    public function getTeacherIdsByCourseId($courseId);

    public function getClassroomTeachersByCourseId($courseId);

    public function getMembersByUser($id, $limit = 15);

    public function getAllCourseIdsByUser($id);
}
