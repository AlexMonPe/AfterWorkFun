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
                'game_id' => 11,
                'user_id' => 11,
            ]
        );

        DB::table('parties')->insert(
            [
                'name' => 'Wednesday party',
                'game_id' => 21,
                'user_id' => 21,
            ]
        );

        DB::table('parties')->insert(
            [
                'name' => 'Friday party',
                'game_id' => 31,
                'user_id' => 31,
            ]
        );

        DB::table('parties')->insert(
            [
                'name' => 'Weekend party',
                'game_id' => 41,
                'user_id' => 41,
            ]
        );
    }
}
