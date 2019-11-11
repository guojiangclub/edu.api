<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/28
 * Time: 18:15
 */

namespace GuoJiangClub\Edu\Backend\Repositories;


use GuoJiangClub\Edu\Backend\Models\VipOrder;
use Prettus\Repository\Eloquent\BaseRepository;

class VipOrderRepository extends BaseRepository
{
    public function model()
    {
        return VipOrder::class;
    }

    public function getOrdersPaginate($where, $andWhere, $limit = 15)
    {
        return $this->scopeQuery(function ($query) use ($where, $andWhere) {
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

            if (count($andWhere) > 0) {
                $query = $query->whereHas('user', function ($query) use ($andWhere) {
                    foreach ($andWhere as $key => $value) {
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

        })->with(['plan', 'user'])->paginate($limit);
    }

    public function getOrderByNo($order_no)
    {
        return $this->with('plan')->findByField('order_no', $order_no)->first();
    }

}