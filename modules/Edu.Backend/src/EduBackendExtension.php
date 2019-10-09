<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/14
 * Time: 16:46
 */
namespace iBrand\Edu\Backend;

use Encore\Admin\Admin;
use Encore\Admin\Extension;
use iBrand\Edu\Backend\Seeds\EduBackendMenuSeeder;
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