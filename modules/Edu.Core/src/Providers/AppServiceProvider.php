<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Providers;

use iBrand\Component\Discount\Contracts\AdjustmentContract;
use iBrand\Component\User\Models\User as BaseUser;
use iBrand\Edu\Core\Auth\User;
use iBrand\Edu\Core\Console\BuildVipPlan;
use iBrand\Edu\Core\Console\SetUserVip;
use iBrand\Edu\Core\Console\SetAdvert;
use iBrand\Edu\Core\Discount\Actions\CourseFixedDiscountAction;
use iBrand\Edu\Core\Discount\Actions\CoursePercentageDiscountAction;
use iBrand\Edu\Core\Models\CourseOrder;
use iBrand\Edu\Core\Models\CourseOrderAdjustment;
use iBrand\Edu\Core\PaidNotify\CoursePaidNotify;
use iBrand\Edu\Core\Policies\CourseOrderPolicy;
use iBrand\Edu\Core\Repositories\CategoryRepository;
use iBrand\Edu\Core\Repositories\CourseAnnouncementRepository;
use iBrand\Edu\Core\Repositories\CourseChapterRepository;
use iBrand\Edu\Core\Repositories\CourseFavoriteRepository;
use iBrand\Edu\Core\Repositories\CourseLessonRepository;
use iBrand\Edu\Core\Repositories\CourseMemberRepository;
use iBrand\Edu\Core\Repositories\CourseOrderRepository;
use iBrand\Edu\Core\Repositories\CourseRepository;
use iBrand\Edu\Core\Repositories\CourseReviewRepository;
use iBrand\Edu\Core\Repositories\CourseTeacherRepository;
use iBrand\Edu\Core\Repositories\Eloquent\CategoryRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\CourseAnnouncementRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\CourseChapterRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\CourseFavoriteRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\CourseLessonRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\CourseMemberRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\CourseOrderRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\CourseRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\CourseReviewRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\CourseTeacherRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\UserDetailsRepositoryEloquent;
use iBrand\Edu\Core\Repositories\Eloquent\VipMemberRepositoryEloquent;
use iBrand\Edu\Core\Repositories\UserDetailsRepository;
use iBrand\Edu\Core\Repositories\VipMemberRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use iBrand\Edu\Core\Models\VipOrder;
use iBrand\Edu\Core\Policies\VipOrderPolicy;
use iBrand\Edu\Core\Console\InstallCommand;
use Event;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        CourseOrder::class => CourseOrderPolicy::class,
        VipOrder::class =>VipOrderPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        $this->loadMigrationsFrom(realpath(__DIR__.'/../../migrations'));

        $this->commands([InstallCommand::class,BuildVipPlan::class, SetUserVip::class,SetAdvert::class]);

        //Event::subscribe('iBrand\Edu\Core\Listeners\Notifications\NotificationsListener');
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
