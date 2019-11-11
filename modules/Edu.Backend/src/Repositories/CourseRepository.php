<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Repositories;

use GuoJiangClub\Edu\Backend\Models\Course;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseRepository extends BaseRepository
{
    public function model()
    {
        return Course::class;
    }

    public function getCoursePaginate($where, $categoryId = [], $limit = 15)
    {
        return $this->scopeQuery(function ($query) use ($where, $categoryId) {
            if (count($where) > 0) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        list($operate, $va) = $value;
                        $query = $query->where($key, $operate, $va);
                    } else {
                        $query = $query->where($key, $value);
                    }
                }
            }

            if (count($categoryId) > 0) {
                $query = $query->whereHas('categories', function ($query) use ($categoryId) {
                    $query->whereIn('category_id', $categoryId);
                });
            }

            return $query->orderBy('created_at', 'desc');
        })->with('teacher')->paginate($limit);
    }
}
