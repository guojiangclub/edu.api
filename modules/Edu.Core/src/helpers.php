<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!function_exists('collect_to_array')) {
    /**
     * @param $collection
     *
     * @return array
     */
    function collect_to_array($collection)
    {
        $array = [];
        foreach ($collection as $item) {
            $array[] = $item;
        }

        return $array;
    }
}

function duration($value)
{
    $minutes = intval($value / 60);
    $seconds = $value - $minutes * 60;
    return sprintf('%02d', $minutes) . ':' . sprintf('%02d', $seconds);
}

function secondsToText($value)
{
    $minutes = intval($value / 60);
    $seconds = $value - $minutes * 60;
    return array($minutes, $seconds);
}

if (!function_exists('getHellobiAvatar')) {
    function getHellobiAvatar($avatar){

        if (!empty($avatar)) {
            $preg = "/^http(s)?:\\/\\/.+/";
            if(preg_match($preg,$avatar))
            {
                return $avatar;
            }
        }

        if (empty($avatar)) {
            return 'https://cdn.ibrand.cc/avatar.png';
        }
        if (strstr($avatar, '000') && (!strstr($avatar, env('ASKSITE')))) {
            return env('ASKSITE') . '/uploads/avatar/' . str_replace('min', 'max', $avatar);
        }

       return env('HOMESITE') . $avatar;
    }
}

if (!function_exists('build_order_no')) {
    function build_order_no($prefix = 'O')
    {
        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）

        $order_id_main = date('Ymd').rand(100000000, 999999999);

        //订单号码主体长度

        $order_id_len = strlen($order_id_main);

        $order_id_sum = 0;

        for ($i = 0; $i < $order_id_len; ++$i) {
            $order_id_sum += (int) (substr($order_id_main, $i, 1));
        }

        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）

        $order_id = $order_id_main.str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);

        return $prefix.$order_id;
    }
}
