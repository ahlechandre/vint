<?php

namespace Modules\System\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
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
    public function abilities()
    {
        return $this->hasMany(Ability::class);
    }
}
