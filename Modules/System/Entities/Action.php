<?php

namespace Modules\System\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'slug'
    ];
}