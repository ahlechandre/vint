<?php

namespace Modules\User\Entities;

use Hash;
use Laravel\Passport\HasApiTokens;
use Modules\Member\Entities\Member;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\System\Entities\Traits\EloquentVint;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, EloquentVint;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password'
    ];

    /**
     *
     * @var array
     */
    protected $filterable = [
        'name', 'username', 'email'
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
    public function userType()
    {
        return $this->belongsTo(UserType::class);
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
        return $this->userType->isAdmin();
    }

    /**
     * Verifica se o usuário tem papel de gerente.
     *
     * @return bool
     */
    public function isManager()
    {
        return $this->userType->isManager();
    }

    /**
     * Verifica se o usuário tem papel de membro.
     *
     * @return bool
     */
    public function isMember()
    {
        return $this->userType->isMember();
    }    
}
