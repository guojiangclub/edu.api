<?php


namespace iBrand\Edu\Backend\Repositories;

use iBrand\Edu\Backend\Models\Discount;
use Prettus\Repository\Eloquent\BaseRepository;


class DiscountRepository extends BaseRepository
{
    public function model()
    {
        return Discount::class;
    }

    public function getDiscountList($where, $orWhere,$limit=15)
    {
        return $this->scopeQuery(function ($query) use ($where, $orWhere) {
            $query = $query->Where(function ($query) use ($where) {
                if (is_array($where)) {
                    foreach ($where as $key => $value) {
                        if (is_array($value)) {
                            list($operate, $va) = $value;
                            $query = $query->where($key, $operate, $va);
                        } else {
                            $query = $query->where($key, $value);
                        }
                    }
                }
            });

            if (count($orWhere)) {
                $query = $query->orWhere(function ($query) use ($orWhere) {
                    if (is_array($orWhere)) {
                        foreach ($orWhere as $key => $value) {
                            if (is_array($value)) {
                                list($operate, $va) = $value;
                                $query = $query->where($key, $operate, $va);
                            } else {
                                $query = $query->where($key, $value);
                            }
                        }
                    }
                });
            }

            return  $query->with('discountActions')->orderBy('created_at', 'desc');
        })->paginate($limit);
    }

}