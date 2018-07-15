<?php

namespace Modules\Group\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Entities\User;

class Member extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'group_id',
        'member_type_id',
        'cpf',
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
    public function memberType()
    {
        return $this->belongsTo(MemberType::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
