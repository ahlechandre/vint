<?php

namespace Modules\Group\Entities;

use Modules\User\Entities\User;
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
            ->withPivot('is_approved');
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
        )->withPivot('is_vice');
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
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeRequestedBy($query, User $user)
    {
        // Retorna todos os grupos que o membero do usuário
        // indicado está relacionado mas não está aprovado.
        return $query->whereHas('members', function ($member) use ($user) {
            return $member->where([
                ['user_id', $user->id],
                ['is_approved', 0]
            ]);
        });
    }
}
