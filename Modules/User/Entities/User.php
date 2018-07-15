<?php

namespace Modules\User\Entities;

use Hash;
use Modules\System\Entities\Role;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Group\Entities\Member;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function member()
    {
        return $this->hasOne(Member::class);
    }    

    /**
     *
     * @param  string  $value
     * @return void
     */
    protected function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Verifica se o usuário tem papel de administrador.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role->isAdmin();
    }

    /**
     * Verifica se o usuário tem papel de gerente.
     *
     * @return bool
     */
    public function isManager()
    {
        return $this->role->isManager();
    }

    /**
     * Verifica se o usuário tem papel de membro.
     *
     * @return bool
     */
    public function isMember()
    {
        return $this->role->isMember();
    }    
}
