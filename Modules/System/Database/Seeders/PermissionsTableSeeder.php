<?php

namespace Modules\System\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\System\Entities\Action;
use Modules\System\Entities\Resource;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $actions = Action::all()
                ->map(function ($action) {
                    return [
                        'action_id' => $action->id,
                    ];
                })->toArray();
            $resources = Resource::all()
                ->map(function ($resource) use ($actions) {
                    return $resource->permissions()
                        ->createMany($actions);
                });
        });
    }
}
