<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Listeners\Notifications;

use GuoJiangClub\Component\User\Repository\UserBindRepository;
use GuoJiangClub\Component\User\Repository\UserRepository;
use GuoJiangClub\Edu\Core\Models\CourseOrder;

//use GuoJiangClub\Hellobi\Repositories\UserRepository as HellobiUser;

/**
 * 课程付款成功微信模板通知
 * Class CourseOrderSuccess.
 */
class CourseOrderSuccess
{
    protected $userRepository;

    protected $userBindRepository;

    protected $user;

    public function __construct(UserRepository $userRepository, UserBindRepository $userBindRepository, HellobiUser $user)
    {
        $this->userRepository = $userRepository;

        $this->userBindRepository = $userBindRepository;

        $this->user = $user;
    }

    public function handle(CourseOrder $order)
    {
        try {
            if (0 == $order->total) {
                return $order;
            }

            $app_id = config('ibrand.wechat.official_account.default.app_id');

            $course = $order->course;

            $users = $this->user->getUsersByRole('super_admin');

            $openIds = [];

            $ids = [];

            if ($users->count() > 0) {
                $ids = $users->pluck('id')->toArray();
            }

            if (isset($course->teacher)) {
                $ids[] = $course->teacher->user_id;
            }

            if (count($ids) > 0) {
                foreach ($ids as $id) {
                    $open_id = $this->getOpenId($id, $app_id);

                    if ($open_id and !in_array($open_id, $openIds)) {
                        $openIds[] = $open_id;
                    }
                }
            }

            if (0 == count($openIds)) {
                return $order;
            }

            \Log::info($openIds);

            $payment = $order->payment;

            switch ($payment) {
              case 'alipay_wap':
              case 'alipay_pc_direct':
                  $payment = '支付宝支付';
                  break;
              case 'wx_pub':
              case 'wx_pub_qr':
              case 'wx_lite':
                  $payment = '微信支付';
                  break;
              default:
                  $payment = '其他';
          }

            $user = $this->userRepository->findByField('id', $order->user_id)->first();

            $user_name = isset($user->user_name) ? $user->user_name : (!empty($user) ? $user->nick_name : '');

            $userName = $user_name ? $user_name : substr_replace($user->mobile, '****', 3, 4);

            foreach ($openIds as $open_id) {
                $message = [
                  'template_id' => 'CZm0SGw1dIS5MMWzCjzoeLMJ5ijr6vdS6Dj9jq6I9lE',
                  'url' => '',
                  'touser' => $open_id,
                  'data' => ['first' => '你有一个学员付款成功',
                          'keyword1' => $order->sn,
                          'keyword2' => $payment,
                          'keyword3' => $order->display_total,
                          'keyword4' => $userName,
                          'remark' => $order->title, ],
              ];

                platform_application()->sendTemplateMessage($app_id, $message);
            }

            return $order;
        } catch (\Exception $e) {
            \Log::info($e);
        }
    }

    protected function getOpenId($user_id, $app_id)
    {
        $userBind = $this->userBindRepository->getByUserIdAndAppId($user_id, $app_id);

        $open_id = $userBind->count() ? $userBind->first()->open_id : '';

        return $open_id;
    }
}
