<?php

namespace iBrand\Edu\Backend\Models;


class CourseOrderAdjustment extends \iBrand\Edu\Core\Models\CourseOrderAdjustment
{

    public function getOrderAdjustmentHistory($where, $limit = 50, $time = [])
    {

        if(isset($where['order_no'])){
            $order_no=$where['sn'];
            unset($where['order_no']);
        }

        $query = $this->model->whereIn('origin_type', ['discount', 'discount_by_market_price']);

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

        if(isset($order_no[1])){
            $query = $query
                ->whereHas('order', function ($query) use ($order_no) {
                    return $query->where('sn','like',$order_no[1]);
                })
                ->with('order.user')->orderBy('created_at', 'desc');
        }else{
            $query = $query->with('order')->with('order.user')->orderBy('created_at', 'desc');
        }


        if ($limit == 0) {
            return $query->all();
        } else {
            return $query->paginate($limit);
        }


    }
}