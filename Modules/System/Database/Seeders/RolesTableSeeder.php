<?php

namespace Modules\System\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Role;

class RolesTableSeeder extends Seeder
{

    /**
     * @var array
     */
    protected $roles = [
        [
            'name' => 'Administrador',
            'slug' => Role::ADMIN_SLUG,
            'description' => 'Papel destinado aos usuários administradores do sistema',
        ],
        [
            'name' => 'Gerente',
            'slug' => Role::MANAGER_SLUG,
            'description' => 'Papel destinado aos usuários gerentes do sistema',
        ],
        [
            'name' => 'Membro',
            'slug' => Role::MEMBER_SLUG,
            'description' => 'Papel destinado aos usuários membros de grupos de pesquisa e extensão',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $seed = function ($role) {
                return Role::create($role);
            };
            array_map($seed, $this->roles);
        });
    }
}
