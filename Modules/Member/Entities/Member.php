<?php

namespace Modules\Member\Entities;

use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\System\Entities\Traits\EloquentVint;
use Modules\Product\Entities\Publication;

class Member extends Model
{
    use SoftDeletes, EloquentVint;

    /**
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * @var array
     */
    protected $fillable = [
        'cpf',
        'role_id',
        'description'
    ];

    /**
     *
     * @var array
     */
    protected $filterable = [
        'description'
    ];

    /**
     *
     * @var array
     */
    protected $filterableRelations = [
        'user',
        'role',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class)
            ->withPivot('is_approved')
            ->withTimestamps();
    }

    /**
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function groupsApproved()
    {
        return $this->groups()
            ->wherePivot('is_approved', 1);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function servant()
    {
        return $this->hasOne(Servant::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function collaborator()
    {
        return $this->hasOne(Collaborator::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publications()
    {
        return $this->belongsToMany(Publication::class)
            ->withTimestamps();
    }

    /**
     *
     * @return bool
     */
    public function isServant()
    {
        return $this->role->isServant();
    }

    /**
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->role->isStudent();
    }

    /**
     *
     * @return bool
     */
    public function isCollaborator()
    {
        return $this->role->isCollaborator();
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, User $user)
    {
        if (!$user->isMember()) {
            return $query;
        }
        $groupsId = $user->member
            ->groupsApproved()
            ->pluck('id');

        return $query->whereHas('groupsApproved', function ($groups) use ($groupsId) {
            return $groups->whereIn('id', $groupsId);
        });
    }
}
