<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Modules\Group\Entities\Invite;
use Modules\Group\Entities\Member;
use Modules\Group\Entities\GroupRole;
use Modules\User\Policies\UserPolicy;
use Modules\Group\Policies\GroupPolicy;
use Modules\Group\Policies\InvitePolicy;
use Modules\Group\Policies\GroupRolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Group\Policies\MemberPolicy;

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
        GroupRole::class => GroupRolePolicy::class,
        Invite::class => InvitePolicy::class,
        Member::class => MemberPolicy::class,
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
