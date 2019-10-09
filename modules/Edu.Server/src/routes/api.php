<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('home/index', 'HomeController@index');
Route::get('home/courses', 'HomeController@courses');

Route::get('courses', 'CourseController@index');

Route::get('course/search', 'CourseController@searchCourses');

Route::get('course/{id}', 'CourseController@show');
Route::get('course/{id}/lessons', 'CourseController@lessons');

Route::get('course/{id}/announcement', 'CourseController@getAnnouncement');

Route::post('coupon', 'CouponController@create')->name('api.coupon.create');

Route::get('teacher/{id}', 'UserController@teacher');

Route::get('system/init', 'SystemSettingController@init')->name('api.system.init');

Route::get('avert/svip/course', 'AdvertController@svipCourse');

Route::get('coterie/{id}', 'UserController@coterie');

Route::middleware(['auth:api'])->group(function () {
    Route::post('coupon/take', 'CouponController@take')->name('api.coupon.take');
    Route::post('course/order/create', 'CourseOrderController@create')->name('api.course.order.create');
    Route::post('course/order/charge', 'CourseOrderController@charge')->name('api.course.order.charge');
    Route::post('course/order/paid', 'CourseOrderController@paid')->name('api.course.order.paid');
    Route::get('course/lesson/{id}', 'LessonController@show');

    //个人中心
    Route::get('me', 'UserController@me');
    Route::post('users/update/details', 'UserController@updateDetails');
    Route::post('users/update/mobile', 'UserController@updateMobile');
    Route::get('users/coupons', 'UserController@coupons');

    Route::get('my/courses', 'MyCourseController@index');

    Route::get('my/courses/announcement', 'MyCourseController@getCoursesAnnouncement');
});
