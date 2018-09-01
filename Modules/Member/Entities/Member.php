<?php

namespace Modules\Member\Entities;

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
        'cpf',
        'role_id',
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
    public function groups()
    {
        return $this->belongsToMany(Group::class)
            ->withPivot('is_approved');
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