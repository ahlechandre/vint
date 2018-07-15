<?php

namespace Modules\Group\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invite extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'token',
        'expires_at',
        'user_id'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at', 'expires_at'
    ];

    /**
     * 
     * @return string
     */
    public function getUrlAttribute()
    {
        return url("invites?token={$this->token}");
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
    public function group()
    {
        return $this->belongsTo(Group::class);
    }    
}
