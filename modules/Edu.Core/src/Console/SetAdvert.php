<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Console;

use GuoJiangClub\Component\Advert\Models\Advert;
use Illuminate\Console\Command;

class SetAdvert extends Command
{
    protected $signature = 'ibrand:set-advert';

    protected $description = 'build an advert';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //edu.home.banner
        $advert_banner = Advert::create(['name' => '首页banner', 'code' => 'edu.home.banner']);

        $advert_banner->addAdvertItem(['name' => '666年度会员', 'image' => 'https://hellobi-dev-admin.ibrand.cc/assets/hellobi/img/svip_66600.png']);

        $advert_banner->addAdvertItem(['name' => '998年度会员', 'image' => 'https://hellobi-dev-admin.ibrand.cc/assets/hellobi/img/svip_99800.png']);

        $advert_banner->addAdvertItem(['name' => '1188年度会员', 'image' => 'https://hellobi-dev-admin.ibrand.cc/assets/hellobi/img/svip_1188.png']);

        //edu.home.svip
        $advert_svip = Advert::create(['name' => '首页svip', 'code' => 'edu.home.svip']);

        $advert_svip->addAdvertItem(['name' => 'svip广告', 'image' => 'https://hellobi-dev-admin.ibrand.cc/assets/hellobi/img/svip_66600.png']);

        //svip.course.machine
        $svip_course_machine = Advert::create(['name' => '人工智能、机器学习', 'code' => 'svip.course.machine']);

        $svip_course_machine->addAdvertItem(['name' => '1', 'associate_id' => 1, 'associate_type' => 'course']);

        $svip_course_machine->addAdvertItem(['name' => '1', 'associate_id' => 2, 'associate_type' => 'course']);

        //svip.course.business
        $svip_course_business = Advert::create(['name' => '业务、分析、求职面试', 'code' => 'svip.course.business']);

        $svip_course_business->addAdvertItem(['name' => '1', 'associate_id' => 3, 'associate_type' => 'course']);

        $svip_course_business->addAdvertItem(['name' => '1', 'associate_id' => 4, 'associate_type' => 'course']);

        //svip.course.bigdata
        $svip_course_bigdata = Advert::create(['name' => '大数据、数据挖掘', 'code' => 'svip.course.bigdata']);

        $svip_course_bigdata->addAdvertItem(['name' => '1', 'associate_id' => 5, 'associate_type' => 'course']);

        $svip_course_bigdata->addAdvertItem(['name' => '1', 'associate_id' => 6, 'associate_type' => 'course']);

        //svip.course.bi
        $svip_course_bi = Advert::create(['name' => '商业智能BI', 'code' => 'svip.course.bi']);

        $svip_course_bi->addAdvertItem(['name' => '1', 'associate_id' => 7, 'associate_type' => 'course']);

        $svip_course_bi->addAdvertItem(['name' => '1', 'associate_id' => 8, 'associate_type' => 'course']);

        //svip.course.other
        $svip_course_other = Advert::create(['name' => '商业智能BI', 'code' => 'svip.course.other']);

        $svip_course_other->addAdvertItem(['name' => '1', 'associate_id' => 9, 'associate_type' => 'course']);

        $svip_course_other->addAdvertItem(['name' => '1', 'associate_id' => 10, 'associate_type' => 'course']);

        $this->info('advert created successfully.');
    }
}
