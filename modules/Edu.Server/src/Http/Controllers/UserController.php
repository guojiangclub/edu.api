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

use GuoJiangClub\Common\Controllers\Controller;
use GuoJiangClub\Common\Wechat\Platform\Services\MiniProgramService;
use GuoJiangClub\Component\User\Repository\UserRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseMemberRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseTeacherRepository;
use GuoJiangClub\Edu\Core\Repositories\UserDetailsRepository;
use GuoJiangClub\Edu\Core\Services\CourseService;
use GuoJiangClub\Edu\Server\Resources\Coupon;
use GuoJiangClub\Sms\Facade as Sms;
use iBrand\Component\Discount\Repositories\CouponRepository;

class UserController extends Controller
{
    protected $details;
    protected $member;
    protected $user;
    protected $coupon;
    protected $coterie;
    protected $miniProgramService;
    protected $teacher;

    public function __construct(UserDetailsRepository $userDetailsRepository, CourseMemberRepository $memberRepository, UserRepository $userRepository, CouponRepository $couponRepository, MiniProgramService $miniProgramService, CourseTeacherRepository $teacherRepository)
    {
        $this->details = $userDetailsRepository;
        $this->member = $memberRepository;
        $this->user = $userRepository;
        $this->coupon = $couponRepository;
        $this->miniProgramService = $miniProgramService;
        $this->teacher = $teacherRepository;
    }

    public function me()
    {
        $user = request()->user();

        $coupons = $this->coupon->findActiveByUser($user->id);

        return $this->success(compact('user', 'coupons'));
    }

    public function teacher($id)
    {
        $course_id = request('course_id');

        $user = $this->teacher->with('details')->findByField(['user_id' => $id, 'course_id' => $course_id])->first();

        if ($user) {
            $user->avatar = getHellobiAvatar($user->avatar);
        }

        //$user= $this->user->findByField('id',$id)->first();

        $members = app(CourseService::class)->getCoursesByTeacher($id);

        $coteries = null;

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

        $this->user->update(['mobile' => $mobile], $user->id);

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

    public function coterie($id)
    {
        $user = null;

        $coterie = null;

        if (!$coterie) {
            return $this->success();
        }

        $user = $this->user->findByField('id', $coterie->user_id)->first();

        $scene = $id.'_';

        $pages = request('pages') ? request('pages') : 'pages/index/index/index';

        $mini_code = platform_application()->createMiniQrcode(config('ibrand.wechat.mini_program.coterie.app_id'), $pages, 800, $scene, 'share_coterie_content', $storage = 'public', client_id());

        return $this->success(['coterie' => $coterie, 'user' => $user, 'mini_code' => $mini_code]);
    }
}
