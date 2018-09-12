<?php

namespace Modules\System\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    const SLUG_PROGRAMS = 'programs';
    const SLUG_PROJECTS = 'projects';
    const SLUG_PRODUCTS = 'products';
    const SLUG_PUBLICATIONS = 'publications';
    const SLUG_MEMBERS_REQUESTS = 'members_requests';
    const SLUG_PROGRAMS_REQUESTS = 'programs_requests';
    const SLUG_PROJECTS_REQUESTS = 'projects_requests';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'slug'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
