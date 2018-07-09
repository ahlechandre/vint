<?php

namespace Modules\System\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'resource_id', 'method_id'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function method()
    {
        return $this->belongsTo(Method::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }
}
