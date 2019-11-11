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

use GuoJiangClub\Edu\Backend\Models\CourseOrderAdjustment;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseOrderAdjustmentRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseOrderAdjustment::class;
    }

    public function getOrderAdjustmentHistory($where, $time = [], $userwhere = [], $orderwhere = [], $limit = 15, $origin_type = ['coupon'], $origin_id = [])
    {
        $query = $this->model->whereIn('origin_type', $origin_type);

        $query = $query->whereIn('origin_id', $origin_id);

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

        if (count($time) > 0) {
            foreach ($time as $key => $value) {
                if (is_array($value)) {
                    list($operate, $va) = $value;
                    $query = $query->where($key, $operate, $va);
                } else {
                    $query = $query->where($key, $value);
                }
            }
        }

        if (count($orderwhere) > 0) {
            $query = $query->whereHas('order', function ($query) use ($orderwhere) {
                foreach ($orderwhere as $key => $value) {
                    if (is_array($value)) {
                        list($operate, $va) = $value;
                        $query = $query->where($key, $operate, $va);
                    } else {
                        $query = $query->where($key, $value);
                    }
                }
            });
        }
        if (count($userwhere) > 0) {
            $query = $query->whereHas('order.user', function ($query) use ($userwhere) {
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

        $query = $query->with('order')->with('order.user');

        if (0 == $limit) {
            return $query->orderBy('created_at', 'desc')->all();
        }

        return $query->orderBy('created_at', 'desc')->paginate($limit);
    }
}
