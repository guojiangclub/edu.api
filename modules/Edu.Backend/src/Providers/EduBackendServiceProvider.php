<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Providers;

use GuoJiangClub\Edu\Backend\EduBackendExtension;
use iBrand\UEditor\UEditorServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class EduBackendServiceProvider extends ServiceProvider
{
    protected $namespace = 'GuoJiangClub\Edu\Backend\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'edu-backend');

        if (!$this->app->routesAreCached()) {
            $this->mapWebRoutes();
        }

        $this->publishes([
            __DIR__.'/../../resources/assets' => public_path('assets/edu-backend'),
        ], 'edu-backend-assets');

        EduBackendExtension::boot();
    }

    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => ['web', 'admin'],
            'namespace' => $this->namespace,
        ], function ($router) {
            require __DIR__.'/../Http/routes.php';
        });
    }

    public function register()
    {
        $this->app->register(UEditorServiceProvider::class);
    }
}
