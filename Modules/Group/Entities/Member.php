<?php

namespace Modules\Group\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Entities\User;

class Member extends Model
{
    use SoftDeletes;

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
        'group_id',
        'cpf',
        'description'
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
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', 1);
    }

    /**
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeNotApproved($query)
    {
        return $query->where('is_approved', 0);
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
}
