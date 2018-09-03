<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use SoftDeletes;

    const ADMIN_SLUG = 'admin';
    const MANAGER_SLUG = 'manager';
    const MEMBER_SLUG = 'member';

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Escopo de papéis permitidos para o usuário indicado.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Modules\User\Entities\User  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($query, User $user)
    {
        // Todos os papéis para administrador.
        if ($user->isAdmin()) {
            return $query;
        }
    
        if ($user->isManager()) {
            return $query->where('slug', '!=', self::ADMIN_SLUG);
        }

        return $query->whereNotIn('slug', [self::ADMIN_SLUG, self::MANAGER_SLUG]);
    }

    /**
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return Builder
     */
    public function scopeAdmin($query) 
    {
        return $query->where('slug', self::ADMIN_SLUG);
    }

    /**
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return Builder
     */
    public function scopeManager($query) 
    {
        return $query->where('slug', self::MANAGER_SLUG);
    }

    /**
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return Builder
     */
    public function scopeMember($query) 
    {
        return $query->where('slug', self::MEMBER_SLUG);
    }

    /**
     * Escopo de papéis permitidos em formulário genérico de usuários.
     * 
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return Builder
     */
    public function scopeForUsersForm($query) 
    {
        return $query->where('slug', '!=', self::MEMBER_SLUG);
    }

    /**
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->slug === self::ADMIN_SLUG;
    }

    /**
     *
     * @return bool
     */
    public function isManager()
    {
        return $this->slug === self::MANAGER_SLUG;
    }

    /**
     *
     * @return bool
     */
    public function isMember()
    {
        return $this->slug === self::MEMBER_SLUG;
    }
}
