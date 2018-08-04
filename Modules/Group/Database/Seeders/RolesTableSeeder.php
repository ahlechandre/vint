<?php

namespace Modules\Group\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Group\Entities\Role;

class RolesTableSeeder extends Seeder
{

    /**
     * @var array
     */
    protected $roles = [
        [
            'name' => 'Servidor',
            'slug' => Role::SERVANT_SLUG,
            'description' => 'Papel para membros que são servidores (professor/técnico) no grupo',
        ],
        [
            'name' => 'Aluno',
            'slug' => Role::STUDENT_SLUG,
            'description' => 'Papel para membros que são alunos no grupo',
        ],
        [
            'name' => 'Colaborador',
            'slug' => Role::COLLABORATOR_SLUG,
            'description' => 'Papel para membros que são colaboradores no grupo',
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
