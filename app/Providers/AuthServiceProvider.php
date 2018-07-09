<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Modules\User\Entities\User;
use Modules\System\Entities\Role;
use Modules\User\Entities\Client;
use Illuminate\Support\Facades\Gate;
use Modules\User\Entities\Affiliate;
use Modules\User\Policies\UserPolicy;
use Modules\Contact\Entities\UserPhone;
use Modules\Localization\Entities\City;
use Modules\System\Policies\RolePolicy;
use Modules\User\Policies\ClientPolicy;
use Modules\User\Policies\AffiliatePolicy;
use Modules\Contact\Entities\AffiliatePhone;
use Modules\Contact\Policies\UserPhonePolicy;
use Modules\Localization\Policies\CityPolicy;
use Modules\Contact\Policies\AffiliatePhonePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Affiliate::class => AffiliatePolicy::class,
        Client::class => ClientPolicy::class,
        UserPhone::class => UserPhonePolicy::class,
        AffiliatePhone::class => AffiliatePhonePolicy::class,
        City::class => CityPolicy::class,
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
