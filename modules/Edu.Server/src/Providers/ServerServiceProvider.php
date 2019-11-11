<?php

/*
 * This file is part of ibrand/edu-server.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Server\Providers;

use Illuminate\Support\ServiceProvider;

class ServerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'server');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config.php' => config_path('ibrand/edu.php'),
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config.php', 'ibrand.edu'
        );

        $this->app->register(RouteServiceProvider::class);
    }
}
