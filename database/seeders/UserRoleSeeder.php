<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users_roles')->insert(
            [
                'user_id' => 1,
                'role_id' => 1
            ]
        );

        DB::table('users_roles')->insert(
            [
                'user_id' => 11,
                'role_id' => 1
            ]
        );

        DB::table('users_roles')->insert(
            [
                'user_id' => 21,
                'role_id' => 1
            ]
        );

        DB::table('users_roles')->insert(
            [
                'user_id' => 31,
                'role_id' => 1
            ]
        );

        DB::table('users_roles')->insert(
            [
                'user_id' => 41,
                'role_id' => 1
            ]
        );

        DB::table('users_roles')->insert(
            [
                'user_id' => 1,
                'role_id' => 11
            ]
        );
    }
}
