<?php

namespace Modules\System\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\System\Entities\Action;
use Modules\System\Entities\Resource;

class PermissionsTableSeeder extends Seeder
{
    /**
     *
     * @var array
     */
    static public $permissions = [
        Resource::SLUG_PROGRAMS => [
            Action::SLUG_CREATE,
            Action::SLUG_UPDATE,
            Action::SLUG_DELETE
        ],
        Resource::SLUG_PROJECTS => [
            Action::SLUG_CREATE,
            Action::SLUG_UPDATE,
            Action::SLUG_DELETE
        ],
        Resource::SLUG_PRODUCTS => [
            Action::SLUG_CREATE,
            Action::SLUG_UPDATE,
            Action::SLUG_DELETE
        ],
        Resource::SLUG_PUBLICATIONS => [
            Action::SLUG_CREATE,
            Action::SLUG_UPDATE,
            Action::SLUG_DELETE
        ],
        Resource::SLUG_MEMBERS_REQUESTS => [
            Action::SLUG_VIEW,
            Action::SLUG_UPDATE
        ],
        Resource::SLUG_PROGRAMS_REQUESTS => [
            Action::SLUG_VIEW,
            Action::SLUG_UPDATE
        ],
        Resource::SLUG_PROJECTS_REQUESTS => [
            Action::SLUG_VIEW,
            Action::SLUG_UPDATE
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
            $actions = Action::all();
            $resources = Resource::all();

            foreach (self::$permissions as $resource => $resourceActions) {
                $resources->where('slug', $resource)
                    ->first()
                    ->permissions()
                    ->createMany(
                        $actions->whereIn('slug', $resourceActions)
                            ->map(function ($action) {
                                return [
                                    'action_id' => $action->id
                                ];
                            })->toArray()
                    );
            }
        });
    }
}
