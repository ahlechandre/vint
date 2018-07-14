<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\Traits\BladeUtils;

class AppServiceProvider extends ServiceProvider
{
    use BladeUtils;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mapComponentsToAliases();
        $this->registerBladeGlobals();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
