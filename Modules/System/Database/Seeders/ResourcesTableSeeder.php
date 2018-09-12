<?php

namespace Modules\System\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Resource;

class ResourcesTableSeeder extends Seeder
{
    /**
     * @var array
     */
    protected $resources = [
        [
            'name' => 'Programas',
            'slug' => Resource::SLUG_PROGRAMS,
            'description' => 'Recurso de programas',
        ],
        [
            'name' => 'Projetos',
            'slug' => Resource::SLUG_PROJECTS,
            'description' => 'Recurso de projetos',
        ],
        [
            'name' => 'Produtos',
            'slug' => Resource::SLUG_PRODUCTS,
            'description' => 'Recurso de produtos',
        ],
        [
            'name' => 'Publicações',
            'slug' => Resource::SLUG_PUBLICATIONS,
            'description' => 'Recurso de publicações',
        ],
        [
            'name' => 'Solicitações de membros',
            'slug' => Resource::SLUG_MEMBERS_REQUESTS,
            'description' => 'Recurso de solicitações de membros em grupos',
        ],
        [
            'name' => 'Solicitações de programas',
            'slug' => Resource::SLUG_PROGRAMS_REQUESTS,
            'description' => 'Recurso de solicitações de programas em grupos',
        ],
        [
            'name' => 'Solicitações de projetos',
            'slug' => Resource::SLUG_PROJECTS_REQUESTS,
            'description' => 'Recurso de solicitações de projetos em grupos',
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
            $seed = function ($resource) {
                return Resource::create($resource);
            };
            array_map($seed, $this->resources);
        });
    }
}
