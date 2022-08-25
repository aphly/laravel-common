<?php

namespace Aphly\LaravelCommon;

use Aphly\Laravel\Providers\ServiceProvider;
use Aphly\LaravelCommon\Middleware\UserAuth;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
		$this->mergeConfigFrom(
            __DIR__.'/config/common.php', 'common'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/common.php' => config_path('common.php'),
            __DIR__.'/config/common_init.sql' => storage_path('app/private/common_init.sql'),
            __DIR__.'/public' => public_path('vendor/laravel-common')
        ]);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-common');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->addMiddlewareAlias('userAuth', UserAuth::class);
    }

}
