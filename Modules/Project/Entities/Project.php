<?php

namespace Modules\Project\Entities;

use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Modules\Member\Entities\Member;
use Modules\Member\Entities\Servant;
use Modules\Member\Entities\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\Member\Entities\Collaborator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\System\Entities\Traits\EloquentVint;
use Modules\Product\Entities\Publication;
use Modules\Product\Entities\Product;

class Project extends Model
{
    use SoftDeletes, EloquentVint;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'start_on',
        'finish_on'
    ];
    
    /**
     * @var array
     */
    protected $filterable = [
        'name',
        'description',
        'start_on',
        'finish_on'
    ];
        
    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'start_on',
        'finish_on'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        // Por padrão, seleciona apenas os programas aprovados. 
        static::addGlobalScope('approved', function (Builder $builder) {
            return $builder->where('is_approved', 1);
        });
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coordinator()
    {
        return $this->belongsTo(Servant::class, 'coordinator_user_id', 'member_user_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(Servant::class, 'leader_user_id', 'member_user_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supporter()
    {
        return $this->belongsTo(Collaborator::class, 'supporter_user_id', 'member_user_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'project_student',
            'project_id',
            'student_user_id'
        )->withPivot('is_scholarship')->withTimestamps();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publications()
    {
        return $this->belongsToMany(Publication::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', 1);
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotApproved($query)
    {
        return $query->where('is_approved', 0);
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Modules\Member\Entities\Member  $member
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfMember($query, Member $member)
    {
        return $query->where('coordinator_user_id', $member->user_id)
            ->orWhere('leader_user_id', $member->user_id)
            ->orWhere('supporter_user_id', $member->user_id)
            ->orWhereHas('students', function ($students) use ($member) {
                return $students->where('student_user_id', $member->user_id);
            });
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Modules\Member\Entities\Member  $member
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForMember($query, Member $member)
    {
        return $query->whereIn('group_id', $member->groupsApproved()
            ->pluck('id')
            ->toArray()
        );
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

        return $this->forMember($user->member);
    }    
}
