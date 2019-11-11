<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Server\Http\Controllers;

use GuoJiangClub\Common\Controllers\Controller;
use GuoJiangClub\Component\Advert\Repositories\AdvertItemRepository;

class AdvertController extends Controller
{
    protected $advertItemRepository;

    public function __construct(AdvertItemRepository $advertItemRepository)
    {

        $this->advertItem=$advertItemRepository;
    }

    public function svipCourse()
    {

        $machineCourses=$this->advertItem->getItemsByCode('svip.course.machine',['teacher']);

        $businessCourses=$this->advertItem->getItemsByCode('svip.course.business',['teacher']);

        $bigdataCourses=$this->advertItem->getItemsByCode('svip.course.bigdata',['teacher']);

        $biCourses=$this->advertItem->getItemsByCode('svip.course.bi',['teacher']);

        $otherCourses=$this->advertItem->getItemsByCode('svip.course.other',['teacher']);

        return $this->success(compact('machineCourses', 'businessCourses','bigdataCourses', 'biCourses','otherCourses'));
    }

}
