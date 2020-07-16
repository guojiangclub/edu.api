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

use iBrand\Common\Controllers\Controller;
use iBrand\Component\Advert\Repositories\AdvertItemRepository;

class AdvertController extends Controller
{
    protected $advertItem;

    public function __construct(AdvertItemRepository $advertItemRepository)
    {
        $this->advertItem = $advertItemRepository;
    }

    public function svipCourse()
    {
        $machineCourses = $this->advertItem->getItemsByCode('svip.course.machine', ['teacher']);

        $businessCourses = $this->advertItem->getItemsByCode('svip.course.business', ['teacher']);

        $bigdataCourses = $this->advertItem->getItemsByCode('svip.course.bigdata', ['teacher']);

        $biCourses = $this->advertItem->getItemsByCode('svip.course.bi', ['teacher']);

        $otherCourses = $this->advertItem->getItemsByCode('svip.course.other', ['teacher']);

        return $this->success(compact('machineCourses', 'businessCourses', 'bigdataCourses', 'biCourses', 'otherCourses'));
    }
}
