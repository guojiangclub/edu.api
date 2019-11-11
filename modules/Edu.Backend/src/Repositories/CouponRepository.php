<?php


namespace GuoJiangClub\Edu\Backend\Repositories;

use GuoJiangClub\Edu\Backend\Models\DiscountCoupon;
use Prettus\Repository\Eloquent\BaseRepository;


class CouponRepository extends BaseRepository
{
    public function model()
    {
        return DiscountCoupon::class;
    }

    public function getCouponsPaginated($where, $time = [], $userwhere = [], $limit = 15)
    {
        $query = $this->model->orderBy('created_at', 'desc');

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

        $query = $query->with('discount')->with('user');

        if ($limit == 0) {
            return $query->all();
        } else {
            return $query->paginate($limit);
        }
    }

}