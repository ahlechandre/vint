<?php

namespace Modules\User\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\UserType;

class UsersTableSeeder extends Seeder
{

    /**
     * @var array
     */
    protected $admins = [
        [
            'name' => 'Administrador Vint',
            'email' => 'admin@vint.com',
            'username' => 'admin',
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
            $userType = UserType::admin()
                ->first();
            $seed = function ($admin) use ($userType) {
                return $userType->users()
                    ->create($admin);
            };
            array_map($seed, $this->admins);
        });
    }
}
