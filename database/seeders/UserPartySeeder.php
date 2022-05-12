<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_parties')->insert(
            [
                'user_id' => 1,
                'party_id' => 1
            ]
        );

        DB::table('users_parties')->insert(
            [
                'user_id' => 2,
                'party_id' => 2
            ]
        );

        DB::table('users_parties')->insert(
            [
                'user_id' => 3,
                'party_id' => 3
            ]
        );

        DB::table('users_parties')->insert(
            [
                'user_id' => 4,
                'party_id' => 4
            ]
        );

        DB::table('users_parties')->insert(
            [
                'user_id' => 5,
                'party_id' => 5
            ]
        );
    }
}
