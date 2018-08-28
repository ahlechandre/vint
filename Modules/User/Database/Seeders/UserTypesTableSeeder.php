<?php

namespace Modules\User\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\UserType;

class UserTypesTableSeeder extends Seeder
{

    /**
     * @var array
     */
    protected $userTypes = [
        [
            'name' => 'Administrador',
            'slug' => UserType::ADMIN_SLUG,
            'description' => 'Tipo destinado aos usuários administradores do sistema',
        ],
        [
            'name' => 'Gerente',
            'slug' => UserType::MANAGER_SLUG,
            'description' => 'Tipo destinado aos usuários gerentes do sistema',
        ],        
        [
            'name' => 'Membro',
            'slug' => UserType::MEMBER_SLUG,
            'description' => 'Tipo destinado aos usuários membros de grupos de pesquisa e extensão',
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
            $seed = function ($userType) {
                return UserType::create($userType);
            };
            array_map($seed, $this->userTypes);
        });
    }
}
