<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parties')->insert(
            [
                'name' => 'Monday party',
                'game_id' => 1,
                'user_id' => 1,
            ]
        );

        DB::table('parties')->insert(
            [
                'name' => 'Tuesday party',
                'game_id' => 2,
                'user_id' => 2,
            ]
        );

        DB::table('parties')->insert(
            [
                'name' => 'Wednesday party',
                'game_id' => 3,
                'user_id' => 3,
            ]
        );

        DB::table('parties')->insert(
            [
                'name' => 'Friday party',
                'game_id' => 4,
                'user_id' => 4,
            ]
        );

        DB::table('parties')->insert(
            [
                'name' => 'Weekend party',
                'game_id' => 5,
                'user_id' => 5,
            ]
        );
    }
}
