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
            'name' => 'Membros',
            'slug' => 'members',
            'description' => 'Recurso de membros',
        ],
        [
            'name' => 'Papéis de membros',
            'slug' => 'members_roles',
            'description' => 'Recurso de papéis de membros',
        ],
        [
            'name' => 'Convites',
            'slug' => 'invites',
            'description' => 'Recurso de convites',
        ],
        [
            'name' => 'Programas',
            'slug' => 'programs',
            'description' => 'Recurso de programas',
        ],
        [
            'name' => 'Projetos',
            'slug' => 'projects',
            'description' => 'Recurso de projetos',
        ],
        [
            'name' => 'Publicações',
            'slug' => 'publications',
            'description' => 'Recurso de publicações',
        ],
        [
            'name' => 'Produtos',
            'slug' => 'products',
            'description' => 'Recurso de produtos',
        ],
        [
            'name' => 'Status de programas',
            'slug' => 'program_status',
            'description' => 'Recurso de status de programas',
        ],
        [
            'name' => 'Status de projetos',
            'slug' => 'project_status',
            'description' => 'Recurso de status de projetos',
        ],
        [
            'name' => 'Status de publicações',
            'slug' => 'publication_status',
            'description' => 'Recurso de status de publicações',
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
