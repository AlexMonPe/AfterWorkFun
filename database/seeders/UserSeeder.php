<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'password' => Hash::make('alex'),
                'steamUserName' => 'yadex'
            ]
        );
        DB::table('users')->insert(
            [
                'nick' => 'mihai',
                'email' => 'mihai@mihai.com',
                'password' => Hash::make('mihai'),
                'steamUserName' => 'daniel'
            ]
        );

        DB::table('users')->insert(
            [
                'nick' => 'yoly',
                'email' => 'yoly@yoly.com',
                'password' => Hash::make('yoly'),
                'steamUserName' => 'yolyty'
            ]
        );

        DB::table('users')->insert(
            [
                'nick' => 'susana',
                'email' => 'susana@susana.com',
                'password' => Hash::make('susana'),
                'steamUserName' => 'susichen'
            ]
        );

        DB::table('users')->insert(
            [
                'nick' => 'rogelio',
                'email' => 'rogelio@rogelio.com',
                'password' => Hash::make('rogelio'),
                'steamUserName' => 'rogthor'
            ]
        );
    }
}
