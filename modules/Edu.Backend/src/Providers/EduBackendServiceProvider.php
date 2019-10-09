<?php

namespace iBrand\Edu\Backend\Providers;

use iBrand\Edu\Backend\EduBackendExtension;
use iBrand\UEditor\UEditorServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;


class EduBackendServiceProvider extends ServiceProvider
{

    protected $namespace = 'iBrand\Edu\Backend\Http\Controllers';


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'edu-backend');

        if (!$this->app->routesAreCached()) {
            $this->mapWebRoutes();
        }

        $this->publishes([
            __DIR__ . '/../../resources/assets' => public_path('assets/edu-backend'),
        ], 'edu-backend-assets');

        EduBackendExtension::boot();

    }


    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => ['web', 'admin'],
            'namespace' => $this->namespace
        ], function ($router) {
            require __DIR__ . '/../Http/routes.php';
        });
    }

    public function register()
    {
        $this->app->register(UEditorServiceProvider::class);

    }
}
