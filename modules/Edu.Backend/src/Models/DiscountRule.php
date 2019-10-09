<?php

namespace iBrand\Edu\Backend\Models;

class DiscountRule extends \iBrand\Component\Discount\Models\Rule
{

    public function setConfigurationAttribute($value)
    {
        $type = $this->attributes['type'];

        if ($type == 'contains_product') {

            $value['sku'] = $this->filterTextArea($value['sku']);

            $this->attributes['configuration'] = json_encode($value);

        } elseif ($type == 'contains_category') {
            //$this->attributes['configuration'] = json_encode(['items' => $value]);
            $this->attributes['configuration'] = json_encode($value);

        } elseif ($type == 'contains_role') {
            $this->attributes['configuration'] = json_encode(['name' => $value]);

        } elseif ($type == 'cart_quantity') {
            $this->attributes['configuration'] = json_encode(['count' => $value]);

        } elseif ($type == 'contains_shops') {
            $this->attributes['configuration'] = json_encode($value);

        } elseif($type == 'contains_wechat_group' ) {
            $this->attributes['configuration'] = json_encode($value);
        } else {
            $this->attributes['configuration'] = json_encode(['amount' => $value * 100]);
        }

    }

    public function getRulesValueAttribute()
    {
        $type = $this->attributes['type'];
        $value = json_decode($this->attributes['configuration'], true);

        if ($type == 'contains_product' OR $type == 'goods_id') {
            return $value;

        } elseif ($type == 'contains_category'){
            // return $value['items'];
            return $value;

        } else {
            return array_values($value)[0];

        }
    }

    public function filterTextArea($val)
    {
        $string = str_replace("\n", ",", $val);
        $string = str_replace("\r\n", ",", $string);

        $string = str_replace(' ', '', $string);
        $data = explode(',', $string);
        foreach ($data as $key => $item) {
            if (empty($item)) unset($data[$key]);
        }

        return implode(',', $data);
    }
}