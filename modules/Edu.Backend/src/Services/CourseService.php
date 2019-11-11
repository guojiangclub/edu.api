<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Services;

use GuoJiangClub\Edu\Core\Repositories\CourseChapterRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseLessonRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseRepository;

class CourseService
{
    protected $courseRepository;

    protected $courseLessonRepository;

    protected $courseChapterRepository;

    public function __construct(CourseRepository $courseRepository, CourseLessonRepository $courseLessonRepository, CourseChapterRepository $courseChapterRepository)
    {
        $this->courseRepository = $courseRepository;

        $this->courseLessonRepository = $courseLessonRepository;

        $this->courseChapterRepository = $courseChapterRepository;
    }

    public function getCourseItems($courseId)
    {
        $lessons = $this->courseLessonRepository->getLessonsByCourseId($courseId);
        $chapters = $this->courseChapterRepository->getChaptersByCourseId($courseId);

        $items = [];
        foreach ($lessons as $lesson) {
            $lesson['itemType'] = 'lesson';
            $items["lesson-{$lesson['id']}"] = $lesson;
        }

        foreach ($chapters as $chapter) {
            $chapter['itemType'] = 'chapter';
            $items["chapter-{$chapter['id']}"] = $chapter;
        }

        uasort($items, function ($item1, $item2) {
            return $item1['seq'] > $item2['seq'];
        });

        return $items;
    }

    public function createChapter(array $data)
    {
        $data['number'] = $this->getNextChapterNumber($data['course_id']);
        $data['seq'] = $this->getNextCourseItemSeq($data['course_id']);

        return $this->courseChapterRepository->create($data);
    }

    public function getNextChapterNumber($courseId)
    {
        $counter = $this->courseChapterRepository->getChapterCountByCourseId($courseId);

        return $counter + 1;
    }

    public function getNextCourseItemSeq($courseId)
    {
        $chapterMaxSeq = $this->courseChapterRepository->getChapterMaxSeqByCourseId($courseId);
        $lessonMaxSeq = $this->courseLessonRepository->getLessonMaxSeqByCourseId($courseId);

        return ($chapterMaxSeq > $lessonMaxSeq ? $chapterMaxSeq : $lessonMaxSeq) + 1;
    }

    public function sortCourseItems($courseId, array $itemIds)
    {
        $items = $this->getCourseItems($courseId);
        $existedItemIds = array_keys($items);

        if (count($itemIds) != count($existedItemIds)) {
            throw new \Exception('itemdIds参数不正确1');
        }

        $diffItemIds = array_diff($itemIds, array_keys($items));
        if (!empty($diffItemIds)) {
            throw new \Exception('itemdIds参数不正确2');
        }

        $lessonId = $chapterId = $seq = 0;
        $currentChapter = ['id' => 0];

        foreach ($itemIds as $itemId) {
            ++$seq;
            list($type) = explode('-', $itemId);
            switch ($type) {
                case 'lesson':
                    $lessonId++;
                    $item = $items[$itemId];
                    $fields = ['number' => $lessonId, 'seq' => $seq, 'chapter_id' => $currentChapter['id']];
                    if ($fields['number'] != $item['number'] or $fields['seq'] != $item['seq'] or $fields['chapter_id'] != $item['chapter_id']) {
                        $this->courseLessonRepository->update($fields, $item['id']);
                    }
                    break;
                case 'chapter':
                    $chapterId++;
                    $item = $currentChapter = $items[$itemId];
                    $fields = ['number' => $chapterId, 'seq' => $seq];
                    if ($fields['number'] != $item['number'] or $fields['seq'] != $item['seq']) {
                        $this->courseChapterRepository->update($fields, $item['id']);
                    }
                    break;
            }
        }
    }

    public function getNextLessonNumber($courseId)
    {
        return $this->courseLessonRepository->getLessonCountByCourseId($courseId) + 1;
    }

    public function createLesson(array $data)
    {
        $course = $this->courseRepository->find($data['course_id']);
        if (empty($course)) {
            throw \Exception('添加课时失败，课程不存在。');
        }

        $data['status'] = 'published' == $course->status ? 1 : 0;
        $data['user_id'] = auth('admin')->user()->id;
        $data['number'] = $this->getNextLessonNumber($data['course_id']);
        $data['seq'] = $this->getNextCourseItemSeq($data['course_id']);
        $lesson = $this->courseLessonRepository->create($data);

        $this->courseRepository->update(['lesson_count' => $this->courseLessonRepository->getLessonCountByCourseId($course->id)], $course->id);

        return $lesson;
    }
}
