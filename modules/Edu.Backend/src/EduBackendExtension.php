<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend;

use Encore\Admin\Admin;
use Encore\Admin\Extension;
use GuoJiangClub\Edu\Backend\Seeds\EduBackendMenuSeeder;
use Illuminate\Support\Facades\Artisan;

class EduBackendExtension extends Extension
{
    /**
     * Bootstrap this package.
     */
    public static function boot()
    {
        Admin::extend('ibrand-edu-backend', __CLASS__);
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        Artisan::call('db:seed', ['--class' => EduBackendMenuSeeder::class]);
    }
}
