<?php

namespace Modules\Group\Entities;

use Modules\User\Entities\User;
use Modules\Member\Entities\Member;
use Modules\Member\Entities\Servant;
use Modules\Project\Entities\Program;
use Modules\Project\Entities\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\System\Entities\Traits\EloquentVint;

class Group extends Model
{
    use SoftDeletes, EloquentVint;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     *
     * @var array
     */
    protected $filterable = [
        'name', 'description'
    ];

    /**
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value, '-');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class)
            ->withPivot('is_approved')
            ->withTimestamps();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function membersNotApproved()
    {
        return $this->members()
            ->wherePivot('is_approved', 0);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function membersApproved()
    {
        return $this->members()
            ->wherePivot('is_approved', 1);
    }

    /**
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function servantMembers()
    {
        return $this->membersApproved()
            ->whereHas('role', function ($role) {
                return $role->servant();
            });
    }

    /**
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function collaboratorMembers()
    {
        return $this->membersApproved()
            ->whereHas('role', function ($role) {
                return $role->collaborator();
            });
    }

    /**
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function studentMembers()
    {
        return $this->membersApproved()
            ->whereHas('role', function ($role) {
                return $role->student();
            });
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coordinators()
    {
        return $this->belongsToMany(
            Servant::class,
            'coordinators',
            'group_id',
            'coordinator_user_id'
        )->withPivot('is_vice')->withTimestamps();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupRoles()
    {
        return $this->hasMany(GroupRole::class);
    }

    /**
     * Determina o escopo de grupos de um usuário.
     * 
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeOfUser($query, User $user)
    {
        if ($user->isAdmin() || $user->isManager()) {
            // Todos os grupos para administradores e gerentes.
            return $query;
        }

        if ($user->isMember()) {
            // Todos grupos em que possuem relacionamento e estão aprovados.
            return $query->whereHas('members', function ($member) use ($user) {
                return $member->where([
                    ['user_id', $user->id],
                    ['is_approved', 1]
                ]);
            });
        }
    }

    /**
     *
     * @param  \Modules\Member\Entities\Servant  $servant
     * @return bool
     */
    public function isCoordinator(Servant $servant)
    {
        return $this->coordinators()
            ->find($servant->member_user_id) ? true : false;
    }

    /**
     *
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function hasCoordinatorUser(User $user)
    {
        return $this->coordinators()
            ->find($user->id) ? true : false;
    }

    /**
     *
     * @param  \Modules\Member\Entities\Member  $member
     * @return bool
     */
    public function isMember(Member $member)
    {
        return $this->members()
            ->find($member->user_id) ? true : false;
    }

    /**
     *
     * @param  \Modules\Member\Entities\Member  $member
     * @return bool
     */
    public function isApprovedMember(Member $member)
    {
        return $this->membersApproved()
            ->find($member->user_id) ? true : false;
    }


    /**
     *
     * @param  \Modules\Member\Entities\Member  $member
     * @return bool
     */
    public function isNotApprovedMember(Member $member)
    {
        return $this->membersNotApproved()
            ->find($member->user_id) ? true : false;
    }

    /**
     *
     * @param  string  $permissionSlug
     * @param  \Modules\User\Entities\User  $user
     * @return bool
     */
    public function allowsForUser($permissionSlug, User $user)
    {
        // Se não é membro, permite.
        if (!$user->isMember()) {
            return true;
        }

        // Se não é membro aprovado do grupo.
        if (!$this->membersApproved()->find($user->id)) {
            return false;
        }
        $explode = explode('.', $permissionSlug);
        $resource = $explode[0];
        $action = $explode[1];
        $groupRole = $this->groupRoles()
            ->where('role_id', $user->member->role_id)
            ->first();
        return $groupRole->permissions
            ->load('action', 'resource')
            ->where('action.slug', $action)
            ->where('resource.slug', $resource)
            ->first() ? true : false;
    }
}
