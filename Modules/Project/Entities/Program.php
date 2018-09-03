<?php

namespace Modules\Project\Entities;

use Modules\User\Entities\User;
use Modules\Group\Entities\Group;
use Modules\Member\Entities\Member;
use Modules\Member\Entities\Servant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\System\Entities\Traits\EloquentVint;

class Program extends Model
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
    protected $dates = [
        'deleted_at',
        'start_on',
        'finish_on'
    ];

    /**
     *
     * @var array
     */
    protected $filterable = [
        'name',
        'description',
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
    public function coordinator()
    {
        return $this->belongsTo(Servant::class, 'coordinator_user_id', 'member_user_id');
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
     * @param  \Modules\Group\Entities\Group  $group
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfGroup($query, Group $group)
    {
        return $query->where('group_id', $group->id);
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Modules\Member\Entities\Member  $member
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfMember($query, Member $member)
    {
        return $query->where('coordinator_user_id', $member->user_id);
    }
}
