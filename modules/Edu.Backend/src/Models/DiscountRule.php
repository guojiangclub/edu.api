<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Models;

class DiscountRule extends \iBrand\Component\Discount\Models\Rule
{
    public function setConfigurationAttribute($value)
    {
        $type = $this->attributes['type'];

        if ('contains_product' == $type) {
            $value['sku'] = $this->filterTextArea($value['sku']);

            $this->attributes['configuration'] = json_encode($value);
        } elseif ('contains_category' == $type) {
            //$this->attributes['configuration'] = json_encode(['items' => $value]);
            $this->attributes['configuration'] = json_encode($value);
        } elseif ('contains_role' == $type) {
            $this->attributes['configuration'] = json_encode(['name' => $value]);
        } elseif ('cart_quantity' == $type) {
            $this->attributes['configuration'] = json_encode(['count' => $value]);
        } elseif ('contains_shops' == $type) {
            $this->attributes['configuration'] = json_encode($value);
        } elseif ('contains_wechat_group' == $type) {
            $this->attributes['configuration'] = json_encode($value);
        } else {
            $this->attributes['configuration'] = json_encode(['amount' => $value * 100]);
        }
    }

    public function getRulesValueAttribute()
    {
        $type = $this->attributes['type'];
        $value = json_decode($this->attributes['configuration'], true);

        if ('contains_product' == $type or 'goods_id' == $type) {
            return $value;
        } elseif ('contains_category' == $type) {
            // return $value['items'];
            return $value;
        }

        return array_values($value)[0];
    }

    public function filterTextArea($val)
    {
        $string = str_replace("\n", ',', $val);
        $string = str_replace("\r\n", ',', $string);

        $string = str_replace(' ', '', $string);
        $data = explode(',', $string);
        foreach ($data as $key => $item) {
            if (empty($item)) {
                unset($data[$key]);
            }
        }

        return implode(',', $data);
    }
}
