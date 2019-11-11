<?php

namespace GuoJiangClub\Edu\Backend\Models;

class DiscountAction extends \iBrand\Component\Discount\Models\Action
{

    public function setConfigurationAttribute($value)
    {
        $type = $this->attributes['type'];

        if($type == 'course_order_fixed_discount')
        {
            $this->attributes['configuration'] = json_encode(['amount' => $value * 100]);
        } else {

            $this->attributes['configuration'] = json_encode(['percentage' => $value]);
        }
    }

    public function getActionValueAttribute()
    {
        $value = json_decode($this->attributes['configuration'], true);
        $keys = array_keys($value);

        foreach ($keys as $val)
        {
            if($val == 'amount')
            {
                return $value['amount'] / 100;
            }else{
                return $value['percentage'];
            }
        }

    }

    public function getActionTypeAttribute()
    {
        $type = '';
        switch ($this->type){
            case 'order_fixed_discount':
                $type='订单减金额';
                break;
            case 'order_percentage_discount':
                $type='订单打折';
                break;
//            case 'goods_fixed_discount':
//                $type='商品减金额';
//                break;
//            case 'goods_percentage_discount':
//                $type='商品打折';
//                break;
//            case 'goods_percentage_by_market_price_discount':
//                $type='员工内购折扣';
//                break;
//            case 'goods_times_point':
//                $type='商品积分';
//            case 'course_order_fixed_discount':
//                $type='商品积分';
            case 'course_order_fixed_discount':
                $type='课程订单减金额';
                break;
            case 'course_order_percentage_discount':
                $type='课程订单打折';
                break;
        }
        return $type;
    }

    public function getActionTextAttribute()
    {
        $type = $this->action_type;
        $value = json_decode($this->attributes['configuration'], true);

        $keys = array_keys($value);

        foreach ($keys as $val)
        {
            if($val == 'amount')
            {
                return $type.($value['amount'] / 100).'元';
            }else{
                return $type.$value['percentage'].'%';
            }
        }
    }
}