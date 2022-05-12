<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert(
            [
                'name' => 'League of Legends',
            ]
        );

        DB::table('games')->insert(
            [
                'name' => 'Call of Duty',
            ]
        );

        DB::table('games')->insert(
            [
                'name' => 'FIFA 22',
            ]
        );

        DB::table('games')->insert(
            [
                'name' => 'MineCraft',
            ]
        );

        DB::table('games')->insert(
            [
                'name' => 'World of Warcraft',
            ]
        );
    }
}
