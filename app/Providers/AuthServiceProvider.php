<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Modules\Group\Entities\Invite;
use Modules\Group\Entities\Member;
use Modules\Group\Entities\GroupRole;
use Modules\Project\Entities\Program;
use Modules\Project\Entities\Project;
use Modules\User\Policies\UserPolicy;
use Modules\Group\Policies\GroupPolicy;
use Modules\Group\Policies\InvitePolicy;
use Modules\Group\Policies\MemberPolicy;
use Modules\Group\Policies\GroupRolePolicy;
use Modules\Project\Policies\ProgramPolicy;
use Modules\Project\Policies\ProjectPolicy;
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
        GroupRole::class => GroupRolePolicy::class,
        Invite::class => InvitePolicy::class,
        Member::class => MemberPolicy::class,
        Program::class => ProgramPolicy::class,
        Project::class => ProjectPolicy::class,
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
