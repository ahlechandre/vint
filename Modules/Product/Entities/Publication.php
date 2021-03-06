<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Entities\User;
use Modules\Project\Entities\Project;
use Modules\Member\Entities\Member;
use Modules\System\Entities\Traits\EloquentVint;

class Publication extends Model
{
    use SoftDeletes, EloquentVint;

    /**
     * @var array
     */
    protected $fillable = [
        'reference', 'url'
    ];

    /**
     * @var array
     */
    protected $filterable = [
        'reference', 'url'
    ];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    } 

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class);
    }
}
