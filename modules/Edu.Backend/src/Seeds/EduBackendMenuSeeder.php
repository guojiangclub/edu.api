<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EduBackendMenuSeeder extends Seeder
{
    public function run()
    {
        $lastOrder = DB::table(config('admin.database.menu_table'))->max('order');

        $setParent = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => 0,
            'order' => $lastOrder++,
            'title' => '在线教育',
            'icon' => '',
            'blank' => 1,
            'uri' => 'edu/course/list',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        //1.
        $parent_course = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $setParent,
            'order' => $lastOrder++,
            'title' => '课程管理',
            'icon' => 'fa-video-camera',
            'blank' => 1,
            'uri' => '#',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent_course,
            'order' => $lastOrder++,
            'title' => '所有课程',
            'icon' => '',
            'blank' => 0,
            'uri' => 'edu/course/list',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent_course,
            'order' => $lastOrder++,
            'title' => '课程方向',
            'icon' => '',
            'blank' => 0,
            'uri' => 'edu/category/list?group_id=1',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent_course,
            'order' => $lastOrder++,
            'title' => '课程形式',
            'icon' => '',
            'blank' => 0,
            'uri' => 'edu/category/list?group_id=2',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent_course,
            'order' => $lastOrder++,
            'title' => '课程标签',
            'icon' => '',
            'blank' => 0,
            'uri' => 'edu/category/list?group_id=3',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        //2.
        $parent_discount = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $setParent,
            'order' => $lastOrder++,
            'title' => '促销管理',
            'icon' => 'fa-credit-card-alt',
            'blank' => 1,
            'uri' => '#',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent_discount,
            'order' => $lastOrder++,
            'title' => '优惠券管理',
            'icon' => '',
            'blank' => 0,
            'uri' => 'edu/discount/list',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        //3.
        $parent_order = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $setParent,
            'order' => $lastOrder++,
            'title' => '订单管理',
            'icon' => 'fa-newspaper-o',
            'blank' => 1,
            'uri' => 'edu/order/list',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        //4.
        $parent_svip = DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $setParent,
            'order' => $lastOrder++,
            'title' => 'SVIP管理',
            'icon' => 'fa-users',
            'blank' => 1,
            'uri' => '#',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent_svip,
            'order' => $lastOrder++,
            'title' => 'SVIP计划管理',
            'icon' => '',
            'blank' => 0,
            'uri' => 'edu/svip/plan/list',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);

        DB::table(config('admin.database.menu_table'))->insertGetId([
            'parent_id' => $parent_svip,
            'order' => $lastOrder++,
            'title' => 'SVIP订单管理',
            'icon' => '',
            'blank' => 0,
            'uri' => 'edu/svip/order/list',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }
}
