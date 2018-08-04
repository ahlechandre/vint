<?php

namespace Modules\Group\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    const SERVANT_SLUG = 'servant';
    const STUDENT_SLUG = 'student';
    const COLLABORATOR_SLUG = 'collaborator';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class);
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
     *
     * @return bool
     */
    public function isServant()
    {
        return $this->slug === self::SERVANT_SLUG;
    }

    /**
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->slug === self::STUDENT_SLUG;
    }

    /**
     *
     * @return bool
     */
    public function isCollaborator()
    {
        return $this->slug === self::COLLABORATOR_SLUG;
    }
}
