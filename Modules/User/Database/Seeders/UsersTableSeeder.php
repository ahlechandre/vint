<?php

namespace Modules\User\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\System\Entities\Role;

class UsersTableSeeder extends Seeder
{

    /**
     * @var array
     */
    protected $admins = [
        [
            'name' => 'System Administrator',
            'email' => 'admin@admin.com',
            'password' => '##admin##',
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
            $role = Role::admin()->first();
            $seed = function ($admin) use ($role) {
                return $role->users()
                    ->create($admin);
            };
            array_map($seed, $this->admins);
        });
    }
}
