<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Server\Http\Controllers;

use GuoJiangClub\Common\Controllers\Controller;

class SystemSettingController extends Controller
{
    public function init()
    {
        $data = [
            'online_service_url' => settings('online_service_url') ? settings('online_service_url') : 'tel:'.settings('online_service_phone'),
            'online_service_data' => [
                'online_service_mini_status' => settings('online_service_mini_status') ? settings('online_service_mini_status') : 0,
                'online_service_status' => settings('online_service_status') ? settings('online_service_status') : 0,
                'online_service_type' => settings('online_service_type'),
                'online_service_self' => settings('online_service_self'),
                'online_service_url' => settings('online_service_url'),
            ],
        ];

        return $this->success($data);
    }
}
