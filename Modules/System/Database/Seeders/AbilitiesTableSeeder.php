<?php

namespace Modules\System\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\System\Entities\Method;
use Modules\System\Entities\Resource;

class AbilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $abilities = Method::all()
                ->map(function ($method) {
                    return [
                        'method_id' => $method->id,
                    ];
                })->toArray();
            $resources = Resource::all()
                ->map(function ($resource) use ($abilities) {
                    return $resource->abilities()
                        ->createMany($abilities);
                });
        });
    }
}
