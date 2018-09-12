<?php

namespace Modules\System\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    const SLUG_CREATE = 'create';
    const SLUG_UPDATE = 'update';
    const SLUG_DELETE = 'delete';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'slug'
    ];
}
