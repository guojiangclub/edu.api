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

use iBrand\Component\Discount\Repositories\CouponRepository;
use iBrand\Component\User\Repository\UserRepository;
use iBrand\Edu\Core\Repositories\CourseMemberRepository;
use iBrand\Edu\Core\Repositories\UserDetailsRepository;
use iBrand\Edu\Core\Services\CourseService;
use iBrand\Edu\Server\Resources\Coupon;
use iBrand\Sms\Facade as Sms;
use iBrand\Common\Wechat\Platform\Services\MiniProgramService;
use iBrand\Common\Controllers\Controller;
use iBrand\Edu\Core\Repositories\CourseTeacherRepository;

class UserController extends Controller
{
    protected $details;
    protected $member;
    protected $user;
    protected $coupon;
    protected $coterie;
    protected $miniProgramService;
    protected $teacher;

    public function __construct(UserDetailsRepository $userDetailsRepository, CourseMemberRepository $memberRepository, UserRepository $userRepository, CouponRepository $couponRepository,MiniProgramService $miniProgramService,CourseTeacherRepository $teacherRepository)
    {
        $this->details = $userDetailsRepository;
        $this->member = $memberRepository;
        $this->user = $userRepository;
        $this->coupon = $couponRepository;
        $this->miniProgramService=$miniProgramService;
        $this->teacher=$teacherRepository;
    }

    public function me()
    {
        $user = request()->user();

        $coupons = $this->coupon->findActiveByUser($user->id);

        return $this->success(compact('user','coupons'));
    }

    public function teacher($id)
    {

        $course_id=request('course_id');

        $user=$this->teacher->with('details')->findByField(['user_id'=>$id,'course_id'=>$course_id])->first();

        if($user){

            $user->avatar=getHellobiAvatar($user->avatar);
        }

        //$user= $this->user->findByField('id',$id)->first();

        $members = app(CourseService::class)->getCoursesByTeacher($id);

        $coteries=null;

        return $this->success(compact('user', 'members', 'coteries'));
    }

    public function updateDetails()
    {
        $user = request()->user();

        $input = request(['name', 'mobile', 'weixin', 'company', 'job']);

        $data = $this->details->updateOrCreate(['user_id' => $user->id], $input);

        return $this->success($data);
    }

    public function updateMobile()
    {
        $user = request()->user();

        $mobile = request('mobile');
        $code = request('code');

        if (!Sms::checkCode($mobile, $code)) {
            return $this->failed('验证码错误');
        }

        $this->user->update(['mobile'=>$mobile],$user->id);

        return $this->success();
    }

    public function coupons()
    {
        $type = request('type') ?: 'valid';

        $user = request()->user();

        if ('valid' == $type) {
            $coupons = $this->coupon->findActiveByUser($user->id);
        } elseif ('used' == $type) {
            $coupons = $this->coupon->findUsedByUser($user->id);
        } else {
            $coupons = $this->coupon->findInvalidByUser($user->id);
        }

        return $this->paginator($coupons, Coupon::class);
    }


    public function coterie($id){

        $user=null;

        $coterie=null;

        if(!$coterie){

            return $this->success();

        }

        $user= $this->user->findByField('id',$coterie->user_id)->first();

        $scene=$id.'_';

        $pages = request('pages') ? request('pages') : 'pages/index/index/index';

        $mini_code = platform_application()->createMiniQrcode(config('ibrand.wechat.mini_program.coterie.app_id') ,$pages, 800, $scene, 'share_coterie_content',$storage = 'public', client_id());

        return $this->success(['coterie'=>$coterie,'user'=>$user,'mini_code'=>$mini_code]);


    }
}
