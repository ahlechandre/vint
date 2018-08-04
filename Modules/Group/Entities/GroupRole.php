<?php

namespace Modules\Group\Entities;

use Illuminate\Database\Eloquent\Model;

class GroupRole extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'role_id'
    ];

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
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
