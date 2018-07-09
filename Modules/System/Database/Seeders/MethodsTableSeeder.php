<?php

namespace Modules\System\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Method;

class MethodsTableSeeder extends Seeder
{

    /**
     * @var array
     */
    protected $methods = [
        [
            'name' => 'Indexar',
            'slug' => 'index',
            'description' => 'Método para indexar os recursos',
        ],
        [
            'name' => 'Mostrar',
            'slug' => 'view',
            'description' => 'Método para mostrar um recurso',
        ],
        [
            'name' => 'Criar',
            'slug' => 'create',
            'description' => 'Método para criar um recurso',
        ],
        [
            'name' => 'Atualizar',
            'slug' => 'update',
            'description' => 'Método para editar um recurso',
        ],
        [
            'name' => 'Apagar',
            'slug' => 'delete',
            'description' => 'Método para apagar um recurso',
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
            $seed = function ($method) {
                return Method::create($method);
            };
            array_map($seed, $this->methods);
        });
    }
}
