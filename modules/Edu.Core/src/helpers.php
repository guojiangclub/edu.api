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

if (!function_exists('date_friendly')) {
    /**
     * 时间友好型提示风格化（即微博中的XXX小时前、昨天等等）
     *
     * 即微博中的 XXX 小时前、昨天等等, 时间超过 $time_limit 后返回按 out_format 的设定风格化时间戳
     *
     * @param  int
     * @param  int
     * @param  string
     * @param  array
     * @param  int
     * @return string
     */
    function date_friendly($date, $time_limit = 604800, $out_format = 'Y-m-d H:i', $formats = null, $time_now = null)
    {

        if (!$date) {
            return false;
        }

        $timestamp = is_numeric($date) ? $date : strtotime($date);

        if ($formats == null) {
            $formats = array('YEAR' => '%s 年前'
            , 'MONTH' => '%s 月前'
            , 'DAY' => '%s 天前'
            , 'HOUR' => '%s 小时前'
            , 'MINUTE' => '%s 分钟前'
            , 'SECOND' => '%s 秒前');
        }

        $time_now = $time_now == null ? time() : $time_now;
        $seconds = $time_now - $timestamp;

        if ($seconds == 0) {
            $seconds = 1;
        }

        if (!$time_limit OR $seconds > $time_limit) {
            return date($out_format, $timestamp);
        }

        $minutes = floor($seconds / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $months = floor($days / 30);
        $years = floor($months / 12);

        if ($years > 0) {
            $diffFormat = 'YEAR';
        } else {
            if ($months > 0) {
                $diffFormat = 'MONTH';
            } else {
                if ($days > 0) {
                    $diffFormat = 'DAY';
                } else {
                    if ($hours > 0) {
                        $diffFormat = 'HOUR';
                    } else {
                        $diffFormat = ($minutes > 0) ? 'MINUTE' : 'SECOND';
                    }
                }
            }
        }

        $dateDiff = null;

        switch ($diffFormat) {
            case 'YEAR' :
                $dateDiff = sprintf($formats[$diffFormat], $years);
                break;
            case 'MONTH' :
                $dateDiff = sprintf($formats[$diffFormat], $months);
                break;
            case 'DAY' :
                $dateDiff = sprintf($formats[$diffFormat], $days);
                break;
            case 'HOUR' :
                $dateDiff = sprintf($formats[$diffFormat], $hours);
                break;
            case 'MINUTE' :
                $dateDiff = sprintf($formats[$diffFormat], $minutes);
                break;
            case 'SECOND' :
                $dateDiff = sprintf($formats[$diffFormat], $seconds);
                break;
        }

        return $dateDiff;
    }
}
