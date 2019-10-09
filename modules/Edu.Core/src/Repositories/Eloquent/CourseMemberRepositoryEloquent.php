<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Repositories\Eloquent;

use iBrand\Edu\Core\Models\CourseMember;
use iBrand\Edu\Core\Repositories\CourseMemberRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseMemberRepositoryEloquent.
 */
class CourseMemberRepositoryEloquent extends BaseRepository implements CourseMemberRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseMember::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getCourseTeachersByCourseId($courseId)
    {
        return $this->scopeQuery(function ($query) {
            return $query->with('user');
        })->findWhere(['courseId' => $courseId, 'role' => 'teacher']);
    }

    public function getClassroomTeachersByCourseId($courseId)
    {
        $teachers = [];
        foreach ($courseId as $c) {
            $teachers[] = $this->getCourseTeachersByCourseId($c->id);
        }
        $teacherIds = [];
        if (count($teachers) > 0) {
            foreach ($teachers as $t) {
                $teacherIds[] = $t->where('isVisible', 1)->pluck('user_id');
            }
        }
        $teaId = [];
        foreach ($teacherIds as $y) {
            $teaId[] = $y[0];
        }

        return $teaId;
    }

    public function getMemberByCourseIdAndUser($courseId, $userId)
    {
        if ($member = $this->findWhere(['course_id' => $courseId, 'user_id' => $userId])->first()) {
            return $member;
        }

        return false;
    }

    public function getMemberCountByCourseIdAndRole($courseId, $role = 'student')
    {
        return $this->scopeQuery(function ($query) use ($courseId) {
            return $query
                ->whereNotIn('user_id', [4726, 8043, 33858, 34362, 46848, 46849, 46850, 46851, 46852, 46853, 46854, 46855,
                    46856,
                    46857,
                    46858,
                    46859,
                    46860,
                    46861,
                    46862,
                    46863,
                    46864,
                    46865,
                    46866,
                    46867,
                    46868,
                    46869,
                    46870,
                    46871,
                    46872,
                    47121,
                    47855,
                    49896,
                    49897,
                    49898,
                    49899,
                    49900,
                    49901,
                    49902,
                    49903,
                    54235,
                    49901,
                    49900,
                    54342,
                ]);
        })->findWhere(['course_id' => $courseId, 'role' => $role])
            ->count();
    }

    public function getMembersMyUserIdAndRoleAndIsLearned($userId, $role = 'student', $isLearned = false, $sort = 'created_at', $order = 'desc', $limit = 15)
    {
        return $this->scopeQuery(function ($query) use ($sort, $order, $userId, $role, $isLearned) {
            return $query
                ->where('user_id', $userId)
                ->where('role', $role)
                ->where('isLearned', $isLearned)
                ->with('course')
                ->orderBy($sort, $order);
        })->paginate($limit);
    }

    public function isCourseTeacher($courseId, $user_id)
    {
        return $this->findWhere(['courseId' => $courseId, 'user_id' => $user_id, 'role' => 'teacher'])->count() > 0 ? true : false;
    }

    public function getMembersByTeacher($teacherId, $sort = 'created_at', $order = 'desc', $limit = 15)
    {
        return $this->scopeQuery(function ($query) use ($sort, $order, $teacherId) {
            return $query
                ->where('user_id', $teacherId)
                ->where('role', 'teacher')
                ->with('course')
                ->orderBy($sort, $order);
        })->paginate($limit);
    }

    public function getStudentsByCourseId($courseId, $limit = 20)
    {
        return $this->scopeQuery(function ($query) use ($courseId) {
            return $query
                ->where('role', 'student')
                ->where('course_id', $courseId)
                ->whereNotIn('user_id', [4726, 8043, 33858, 34362, 46848, 46849, 46850, 46851, 46852, 46853, 46854, 46855,
                    46856,
                    46857,
                    46858,
                    46859,
                    46860,
                    46861,
                    46862,
                    46863,
                    46864,
                    46865,
                    46866,
                    46867,
                    46868,
                    46869,
                    46870,
                    46871,
                    46872,
                    47121,
                    47855,
                    49896,
                    49897,
                    49898,
                    49899,
                    49900,
                    49901,
                    49902,
                    49903,
                    54235,
                    49901,
                    49900,
                    54342,
                ])
                ->with('course')
                ->with('user')
                ->orderBy('created_at', 'desc');
        })->paginate($limit);
    }

    public function getCourseVisibleTeacher($courseId)
    {
        return $this->scopeQuery(function ($query) {
            return $query->with('user');
        })->findWhere(['courseId' => $courseId, 'role' => 'teacher', 'isVisible' => 1])->first();
    }

    public function getAllStudentsByCourseId($courseId)
    {
        return $this->scopeQuery(function ($query) use ($courseId) {
            return $query
                ->where('role', 'student')
                ->orderBy('created_at', 'desc');
        })->findByField('courseId', $courseId);
    }

    public function getTeacherIdsByCourseId($courseId)
    {
        return $this->findWhere(['courseId' => $courseId, 'role' => 'teacher'], ['user_id']);
    }

    public function getMembersByUser($id, $limit = 15)
    {
        return $this->scopeQuery(function ($query) use ($id) {
            return $query->where('user_id', $id);
        })->with(['course', 'course.teacher'])->orderBy('created_at', 'desc')->paginate($limit);
    }


    public function getAllCourseIdsByUser($id){

        return $this->model->where('user_id',$id)->pluck('course_id')->toArray();
    }

}
