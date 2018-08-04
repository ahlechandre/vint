<?php

namespace Modules\System\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Action;

class ActionsTableSeeder extends Seeder
{

    /**
     * @var array
     */
    protected $actions = [
        [
            'name' => 'Indexar',
            'slug' => 'index',
            'description' => 'Ação para indexar os recursos',
        ],
        [
            'name' => 'Mostrar',
            'slug' => 'view',
            'description' => 'Ação para mostrar um recurso',
        ],
        [
            'name' => 'Criar',
            'slug' => 'create',
            'description' => 'Ação para criar um recurso',
        ],
        [
            'name' => 'Atualizar',
            'slug' => 'update',
            'description' => 'Ação para editar um recurso',
        ],
        [
            'name' => 'Apagar',
            'slug' => 'delete',
            'description' => 'Ação para apagar um recurso',
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
            $seed = function ($action) {
                return Action::create($action);
            };
            array_map($seed, $this->actions);
        });
    }
}
