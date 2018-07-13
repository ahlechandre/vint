<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Modules\User\Policies\UserPolicy;
use Modules\Group\Policies\GroupPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Group::class => GroupPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
