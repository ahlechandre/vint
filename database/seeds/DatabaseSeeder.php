<?php

use Illuminate\Database\Seeder;
use Modules\System\Database\Seeders\SystemDatabaseSeeder;
use Modules\User\Database\Seeders\UserDatabaseSeeder;
use Modules\Group\Database\Seeders\GroupDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SystemDatabaseSeeder::class,
            UserDatabaseSeeder::class,
            GroupDatabaseSeeder::class,
        ]);
    }
}
