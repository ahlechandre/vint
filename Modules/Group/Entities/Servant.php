<?php

namespace Modules\Group\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Servant extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $primaryKey = 'member_user_id';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'siape',
        'is_professor'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        
        // Por padrão, seleciona apenas registros de servidor cujo 
        // membro ainda está neste papel.
        // Isto é, se um membro já foi servidor está 
        // atualmente com outro papel, ele não será selecionado aqui
        // apesar de existir o seu registro.
        static::addGlobalScope('stillServant', function (Builder $builder) {
            $builder->whereHas('member', function ($member) {
                return $member->whereHas('role', function ($role) {
                    return $role->where('slug', 'servant');
                });
            });
        });
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coordinations()
    {
        return $this->belongsToMany(
            Group::class,
            'coordinators',
            'coordinator_user_id',
            'group_id'
        )->withPivot('is_vice');
    }

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProfessor($query)
    {
        return $query->where('is_professor', 1);
    }
}
