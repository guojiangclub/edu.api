<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/14
 * Time: 19:35
 */

namespace GuoJiangClub\Edu\Backend\Http\Controllers;


use iBrand\Backend\Http\Controllers\Controller;

use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use DB;



class SettingsController extends Controller
{
    public function index()
    {
        $smsSetting = settings('menu_list');

        return LaravelAdmin::content(function (Content $content) use ($smsSetting) {

            $content->header('系统设置');

            $content->breadcrumb(
                ['text' => '系统设置', 'url' => '', 'no-pjax' => 1],
                ['text' => '系统设置', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '系统设置']

            );

            $content->body(view('edu-backend::sys_setting.index', compact('smsSetting')));
        });
    }

    public function saveSettings(Request $request)
    {
        $data = ($request->except('_token', 'file'));


        settings()->setSetting($data);

        $this->ajaxJson();
    }


}