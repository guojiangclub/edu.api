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

use GuoJiangClub\Edu\Backend\Models\CourseOrder;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseOrderRepository extends BaseRepository
{
    public function model()
    {
        return CourseOrder::class;
    }

    public function getOrdersPaginate($where, $userwhere, $coursewhere, $limit = 15)
    {
        $query = $this->scopeQuery(function ($query) use ($where, $userwhere, $coursewhere) {
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

            if (count($userwhere) > 0) {
                $query = $query->whereHas('user', function ($query) use ($userwhere) {
                    foreach ($userwhere as $key => $value) {
                        if (is_array($value)) {
                            list($operate, $va) = $value;
                            $query = $query->where($key, $operate, $va);
                        } else {
                            $query = $query->where($key, $value);
                        }
                    }
                });
            }

            if (count($coursewhere) > 0) {
                $query = $query->whereHas('course', function ($query) use ($coursewhere) {
                    foreach ($coursewhere as $key => $value) {
                        if (is_array($value)) {
                            list($operate, $va) = $value;
                            $query = $query->where($key, $operate, $va);
                        } else {
                            $query = $query->where($key, $value);
                        }
                    }
                });
            }

            return $query->orderBy('created_at', 'desc');
        });

        $query->with('course')->with('user');

        if (0 == $limit) {
            return $query->all();
        }

        return $query->paginate($limit);
    }
}
