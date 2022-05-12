<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'nick' => 'alex',
                'email' => 'alex@alex.com',
                'password' => "alex",
                'steamUserName' => 'yadex'
            ]
        );
        DB::table('users')->insert(
            [
                'nick' => 'mihai',
                'email' => 'mihai@mihai.com',
                'password' => "mihai",
                'steamUserName' => 'daniel'
            ]
        );

        DB::table('users')->insert(
            [
                'nick' => 'yoly',
                'email' => 'yoly@yoly.com',
                'password' => "yoly",
                'steamUserName' => 'yolyty'
            ]
        );

        DB::table('users')->insert(
            [
                'nick' => 'susana',
                'email' => 'susana@susana.com',
                'password' => "susana",
                'steamUserName' => 'susichen'
            ]
        );

        DB::table('users')->insert(
            [
                'nick' => 'rogelio',
                'email' => 'rogelio@rogelio.com',
                'password' => "rogelio",
                'steamUserName' => 'rogthor'
            ]
        );
    }
}
