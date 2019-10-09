<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Server\Http\Controllers;

use iBrand\Component\Discount\Repositories\DiscountRepository;
use iBrand\Edu\Core\Repositories\CategoryRepository;
use iBrand\Edu\Core\Repositories\CourseRepository;
use iBrand\Edu\Server\Resources\Course;
use iBrand\Component\Advert\Repositories\AdvertItemRepository;

use iBrand\Common\Controllers\Controller;

class HomeController extends Controller
{
    protected $category;
    protected $course;
    protected $discount;
    protected $advertItemRepository;

    public function __construct(CategoryRepository $categoryRepository, CourseRepository $courseRepository,
                                DiscountRepository $discountRepository, AdvertItemRepository $advertItemRepository)
    {
        $this->category = $categoryRepository;
        $this->course = $courseRepository;
        $this->discount = $discountRepository;
        $this->advertItem = $advertItemRepository;
    }

    public function index()
    {
        //$this->advertItem->getItemsByCode('svip.course.other',['teacher']);

        $banners = $this->advertItem->getItemsByCode('edu.home.banner');

        $svipBanner = $this->advertItem->getItemsByCode('edu.home.svip');

        $categories = $this->category->orderBy('weight', 'desc')->findByField('groupId', 1);

        $coupons = $this->discount->findActive(1);

        return $this->success(compact('banners', 'svipBanner', 'categories', 'coupons'));
    }

    public function courses()
    {
        $limit = request('limit') ? request('limit') : 15;

        $courses = $this->course->getRecommendCourses($limit);

        return $this->paginator($courses, Course::class)->hide(['about']);
    }
}
