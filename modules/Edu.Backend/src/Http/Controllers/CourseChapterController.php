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

use GuoJiangClub\Edu\Backend\Services\CourseService;
use GuoJiangClub\Edu\Core\Repositories\CourseChapterRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseLessonRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseRepository;
use iBrand\Backend\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseChapterController extends Controller
{
    protected $courseRepository;

    protected $courseLessonRepository;

    protected $courseChapterRepository;

    protected $courseService;

    public function __construct(CourseRepository $courseRepository, CourseLessonRepository $courseLessonRepository,
        CourseService $courseService, CourseChapterRepository $courseChapterRepository)
    {
        $this->courseRepository = $courseRepository;

        $this->courseLessonRepository = $courseLessonRepository;

        $this->courseChapterRepository = $courseChapterRepository;

        $this->courseService = $courseService;
    }

    public function create($courseId)
    {
        $chapter = '';

        return view('edu-backend::lesson.modal.chapter-modal', compact('courseId'));
    }

    public function edit($chapterId)
    {
        $chapter = $this->courseChapterRepository->find($chapterId);

        $courseId = $chapter->course_id;

        return view('edu-backend::lesson.modal.chapter-modal', compact('chapter', 'courseId'));
    }

    public function store($courseId, Request $request)
    {
        if (!request('chapterId')) {
            $item = $this->courseService->createChapter(array_merge($request->except(['_token', 'chapterId']), ['course_id' => $courseId]));
        } else {
            $item = $this->courseChapterRepository->update($request->except(['_token', 'chapterId']), request('chapterId'));
        }

        return view('edu-backend::lesson.includes.chapter-item', compact('item'));
    }

    public function delete($id)
    {
        $this->courseChapterRepository->delete($id);

        return $this->ajaxJson(true, 0, '', []);
    }
}
