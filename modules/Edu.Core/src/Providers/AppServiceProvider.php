<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Providers;

use Event;
use GuoJiangClub\Edu\Core\Console\BuildVipPlan;
use GuoJiangClub\Edu\Core\Console\InstallCommand;
use GuoJiangClub\Edu\Core\Console\SetAdvert;
use GuoJiangClub\Edu\Core\Console\SetUserVip;
use GuoJiangClub\Edu\Core\Discount\Actions\CourseFixedDiscountAction;
use GuoJiangClub\Edu\Core\Discount\Actions\CoursePercentageDiscountAction;
use GuoJiangClub\Edu\Core\Models\CourseOrder;
use GuoJiangClub\Edu\Core\Models\CourseOrderAdjustment;
use GuoJiangClub\Edu\Core\Models\VipOrder;
use GuoJiangClub\Edu\Core\PaidNotify\CoursePaidNotify;
use GuoJiangClub\Edu\Core\Policies\CourseOrderPolicy;
use GuoJiangClub\Edu\Core\Policies\VipOrderPolicy;
use GuoJiangClub\Edu\Core\Repositories\CategoryRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseAnnouncementRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseChapterRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseFavoriteRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseLessonRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseMemberRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseOrderRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseReviewRepository;
use GuoJiangClub\Edu\Core\Repositories\CourseTeacherRepository;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CategoryRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CourseAnnouncementRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CourseChapterRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CourseFavoriteRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CourseLessonRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CourseMemberRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CourseOrderRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CourseRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CourseReviewRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\CourseTeacherRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\UserDetailsRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\Eloquent\VipMemberRepositoryEloquent;
use GuoJiangClub\Edu\Core\Repositories\UserDetailsRepository;
use GuoJiangClub\Edu\Core\Repositories\VipMemberRepository;
use iBrand\Component\Discount\Contracts\AdjustmentContract;
use iBrand\Component\User\Models\User as BaseUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        CourseOrder::class => CourseOrderPolicy::class,
        VipOrder::class => VipOrderPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        $this->loadMigrationsFrom(realpath(__DIR__.'/../../migrations'));

        $this->commands([InstallCommand::class, BuildVipPlan::class, SetUserVip::class, SetAdvert::class]);

        //Event::subscribe('GuoJiangClub\Edu\Core\Listeners\Notifications\NotificationsListener');
    }

    public function register()
    {
        $this->app->bind(BaseUser::class, config('auth.providers.users.model'));
        $this->app->bind(AdjustmentContract::class, CourseOrderAdjustment::class);
        $this->app->bind(CourseFixedDiscountAction::TYPE, CourseFixedDiscountAction::class);
        $this->app->bind(CoursePercentageDiscountAction::TYPE, CoursePercentageDiscountAction::class);

        $this->app->bind('ibrand.pay.notify.default', CoursePaidNotify::class);

        $this->registerComponent();
    }

    protected function registerComponent()
    {
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(CourseRepository::class, CourseRepositoryEloquent::class);
        $this->app->bind(CourseAnnouncementRepository::class, CourseAnnouncementRepositoryEloquent::class);
        $this->app->bind(CourseChapterRepository::class, CourseChapterRepositoryEloquent::class);
        $this->app->bind(CourseFavoriteRepository::class, CourseFavoriteRepositoryEloquent::class);
        $this->app->bind(CourseLessonRepository::class, CourseLessonRepositoryEloquent::class);
        $this->app->bind(CourseMemberRepository::class, CourseMemberRepositoryEloquent::class);
        $this->app->bind(CourseOrderRepository::class, CourseOrderRepositoryEloquent::class);
        $this->app->bind(CourseRepository::class, CourseRepositoryEloquent::class);
        $this->app->bind(CourseReviewRepository::class, CourseReviewRepositoryEloquent::class);
        $this->app->bind(UserDetailsRepository::class, UserDetailsRepositoryEloquent::class);
        $this->app->bind(CourseTeacherRepository::class, CourseTeacherRepositoryEloquent::class);
        $this->app->bind(VipMemberRepository::class, VipMemberRepositoryEloquent::class);
    }

    protected function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
}
