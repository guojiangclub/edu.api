<?php

namespace iBrand\Edu\Backend\Http\Controllers;

use DB;
use Carbon\Carbon;
use iBrand\Backend\Http\Controllers\Controller;
use iBrand\Edu\Backend\Models\Course;
use iBrand\Edu\Backend\Repositories\CourseRepository;
use iBrand\Edu\Core\Repositories\CourseLessonRepository;
use iBrand\Edu\Core\Repositories\CourseChapterRepository;
use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use iBrand\Edu\Backend\Services\CourseService;

class CourseLessonController extends Controller
{
    protected $courseRepository;

    protected $courseLessonRepository;

    protected $courseChapterRepository;

    protected $courseService;

    public function __construct(CourseRepository $courseRepository, CourseLessonRepository $courseLessonRepository
        , CourseChapterRepository $courseChapterRepository
        , CourseService $courseService
    )
    {
        $this->courseRepository = $courseRepository;

        $this->courseLessonRepository = $courseLessonRepository;

        $this->courseChapterRepository = $courseChapterRepository;

        $this->courseService = $courseService;

    }

    public function index($id)
    {

        $course = $this->courseRepository->find($id);

        $courseItems= $this->courseService->getCourseItems($id);


        return LaravelAdmin::content(function (Content $content) use ($courseItems, $course) {

            $content->header('课时管理');

            $content->breadcrumb(
                ['text' => '所有课程', 'url' => 'edu/course/list', 'no-pjax' => 1],
                ['text' => '课时管理', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '所有课程']

            );

            $content->body(view('edu-backend::lesson.index', compact('courseItems', 'course')));
        });

    }

    public function create($courseId)
    {
        $lesson = '';
        return view('edu-backend::lesson.modal.lesson-modal', compact('courseId', 'lesson'));
    }


    public function edit($courseId, $lessonId)
    {
        $lesson = $this->courseLessonRepository->find($lessonId);
        return view('edu-backend::lesson.modal.lesson-modal', compact('lesson', 'courseId'));
    }


    public function store($courseId, Request $request)
    {
        $data = $request->except(['_token', 'lessonId']);
        if (is_numeric($data['second'])) {
            $data['length'] = $this->textToSeconds($data['minute'], $data['second']);
            unset($data['minute']);
            unset($data['second']);
        }
        if (!request('lessonId')) {
            $item = $this->courseService->createLesson(array_merge($data, ['course_id' => $courseId]));
        } else {
            $item = $this->courseLessonRepository->update($data, request('lessonId'));
        }
        return view('edu-backend::lesson.includes.lesson-item', compact('item'));
    }


    public function delete($id)
    {
        $lesson = $this->courseLessonRepository->find($id);

        $this->courseLessonRepository->delete($id);

        $this->courseRepository->update(['lesson_count' => $this->courseLessonRepository->getLessonCountByCourseId($lesson->course_id)], $lesson->course_id);

        return $this->ajaxJson(true, 0, '', []);
    }


    public function publish($id)
    {
        $item = $this->courseLessonRepository->update(['status' => 1], $id);
        return view('edu-backend::lesson.includes.lesson-item', compact('item'));
    }

    public function unpublish($id)
    {
        $item = $this->courseLessonRepository->update(['status' => 0], $id);
        return view('edu-backend::lesson.includes.lesson-item', compact('item'));
    }

    public function sort($id)
    {
        $this->courseService->sortCourseItems($id, request('ids'));
        return $this->ajaxJson(true);
    }

    private function textToSeconds($minutes, $seconds)
    {
        return intval($minutes) * 60 + intval($seconds);
    }


}