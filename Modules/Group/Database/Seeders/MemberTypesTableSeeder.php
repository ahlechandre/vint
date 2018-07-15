<?php

namespace Modules\Group\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Group\Entities\MemberType;

class MemberTypesTableSeeder extends Seeder
{

    /**
     * @var array
     */
    protected $memberTypes = [
        [
            'name' => 'Servidor',
            'slug' => MemberType::SERVANT_SLUG,
            'description' => 'Membros que são servidores (professor/técnico) no grupo',
        ],
        [
            'name' => 'Aluno',
            'slug' => MemberType::STUDENT_SLUG,
            'description' => 'Membros que são alunos no grupo',
        ],
        [
            'name' => 'Colaborador',
            'slug' => MemberType::COLLABORATOR_SLUG,
            'description' => 'Membros que são colaboradores no grupo',
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
            $seed = function ($memberType) {
                return MemberType::create($memberType);
            };
            array_map($seed, $this->memberTypes);
        });
    }
}
