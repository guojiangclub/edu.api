<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$router->group(['prefix' => 'admin/college'], function () use ($router) {
    $router->get('index', 'DashBoardController@index');

    $router->group(['prefix' => 'category'], function () use ($router) {
        $router->get('list', 'CategoryController@index')->name('edu.category.list');
        $router->get('create', 'CategoryController@create')->name('edu.category.create');
        $router->get('{id}/edit', 'CategoryController@edit')->name('edu.category.edit');

        $router->post('store', 'CategoryController@store')->name('edu.category.store');
        $router->post('delete', 'CategoryController@delete')->name('edu.category.delete');
    });

    $router->group(['prefix' => 'course'], function () use ($router) {
        $router->get('update/picture', 'CourseController@updatePicture');

        $router->get('list', 'CourseController@index')->name('edu.course.list');

        $router->get('create', 'CourseController@create')->name('edu.course.create');

        $router->post('store', 'CourseController@store')->name('edu.course.store');

        $router->get('edit/{id}', 'CourseController@edit')->name('edu.course.edit');

        $router->post('update', 'CourseController@update')->name('edu.course.update');

        $router->post('switchRecommend/{id}', 'CourseController@switchRecommend')->name('edu.course.switchRecommend');

        $router->post('switchStatus/{id}', 'CourseController@switchStatus')->name('edu.course.switchStatus');
    });

    //课时
    $router->group(['prefix' => 'course/lesson'], function () use ($router) {
        $router->get('{id}/index', 'CourseLessonController@index')->name('edu.course.lesson.index');

        $router->post('{id}/sort', 'CourseLessonController@sort')->name('edu.course.lesson.sort');

        $router->post('{id}/publish', 'CourseLessonController@publish')->name('edu.course.lesson.publish');

        $router->post('{id}/unpublish', 'CourseLessonController@unpublish')->name('edu.course.lesson.unpublish');

        $router->post('{id}/delete', 'CourseLessonController@delete')->name('edu.course.lesson.delete');

        $router->get('{courseId}/create', 'CourseLessonController@create')->name('edu.course.lesson.create');

        $router->post('{courseId}/store', 'CourseLessonController@store')->name('edu.course.lesson.store');

        $router->get('{courseId}/edit/{lessonId}', 'CourseLessonController@edit')->name('edu.course.lesson.edit');
    });

    // 章节
    $router->group(['prefix' => 'course/chapter'], function () use ($router) {
        $router->post('{id}/delete', 'CourseChapterController@delete')->name('edu.course.chapter.delete');
        $router->get('{chapterId}/edit', 'CourseChapterController@edit')->name('edu.course.chapter.edit');
        $router->get('{courseId}/create', 'CourseChapterController@create')->name('edu.course.chapter.create');
        $router->post('{courseId}/store', 'CourseChapterController@store')->name('edu.course.chapter.store');
    });

    // 学员
    $router->group(['prefix' => 'course/member'], function () use ($router) {
        $router->get('{id}/index', 'CourseMemberController@index')->name('edu.course.member.index');
        $router->post('{id}/remove/{memberId}', 'CourseMemberController@remove')->name('edu.course.member.remove');
        $router->get('{id}/create', 'CourseMemberController@create')->name('edu.course.member.create');
        $router->post('{id}/store', 'CourseMemberController@store')->name('edu.course.member.store');
    });

    $router->group(['prefix' => 'discount'], function () use ($router) {
        $router->get('list', 'DiscountController@index')->name('edu.discount.index');
        $router->get('create', 'DiscountController@create')->name('edu.discount.create');
        $router->post('store', 'DiscountController@store')->name('edu.discount.store');
        $router->get('{id}/edit', 'DiscountController@edit')->name('edu.discount.edit');

        $router->get('useRecord', 'DiscountController@useRecord')->name('edu.discount.useRecord');

        $router->get('showCoupons', 'DiscountController@showCoupons')->name('edu.discount.showCoupons');
    });

    $router->group(['prefix' => 'order'], function () use ($router) {
        $router->get('list', 'CourseOrderController@index')->name('edu.order.list');
        $router->get('{id}/show', 'CourseOrderController@show')->name('edu.order.show');
    });

    $router->group(['prefix' => 'svip/plan'], function () use ($router) {
        $router->get('list', 'SvipController@index')->name('edu.svip.plan.list');
        $router->get('create', 'SvipController@create')->name('edu.svip.plan.create');
        $router->get('{id}/edit', 'SvipController@edit')->name('edu.svip.plan.edit');
        $router->post('store', 'SvipController@store')->name('edu.svip.plan.store');

        $router->get('updateData/vip_member', 'SvipController@updateDataVipMember')->name('edu.svip.plan.updateData.VipMember');
    });

    $router->group(['prefix' => 'svip/order'], function () use ($router) {
        $router->get('list', 'SvipOrderController@index')->name('edu.svip.order.list');
        $router->get('{id}/show', 'SvipOrderController@show')->name('edu.svip.order.show');
    });

    $router->group(['prefix' => 'common/model'], function () use ($router) {
        $router->get('user', 'CommonController@modelUsers')->name('edu.common.users.model');
        $router->get('user/list', 'CommonController@getUserList')->name('edu.common.users.model.list');
    });

    //推广管理
    $router->group(['prefix' => 'ad'], function () use ($router) {
        $router->get("/", "AdvertisementController@index")->name('edu.ad.list');
        $router->get("create", "AdvertisementController@create")->name('edu.ad.create');
        $router->get("edit/{id}", "AdvertisementController@edit")->name('edu.ad.edit');

        $router->post("store", "AdvertisementController@store")->name('edu.ad.store');
        $router->post("destroy/{id}", "AdvertisementController@destroy")->name('edu.ad.destroy');
        $router->post('toggleStatus', 'AdvertisementController@toggleStatus')->name('edu.ad.toggleStatus');


        $router->get("item", "AdvertisementItemController@index")->name('edu.ad.item.index');
        $router->get("item/create", "AdvertisementItemController@create")->name('edu.ad.item.create');
        $router->get("item/edit/{id}", "AdvertisementItemController@edit")->name('edu.ad.item.edit');
        $router->post("item/store", "AdvertisementItemController@store")->name('edu.ad.item.store');
        $router->post("item/destroy/{id}", "AdvertisementItemController@destroy")->name('edu.ad.item.destroy');
        $router->post('item/toggleStatus', 'AdvertisementItemController@toggleStatus')->name('admin.ad.item.toggleStatus');
    });

    $router->get('settings', 'SettingsController@index')->name('edu.settings');
    $router->post('saveSettings', 'SettingsController@saveSettings')->name('edu.settings.saveSettings');


});
