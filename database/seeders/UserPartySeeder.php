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
                'user_id' => 11,
                'party_id' => 11
            ]
        );

        DB::table('users_parties')->insert(
            [
                'user_id' => 21,
                'party_id' => 21
            ]
        );

        DB::table('users_parties')->insert(
            [
                'user_id' => 31,
                'party_id' => 31
            ]
        );

        DB::table('users_parties')->insert(
            [
                'user_id' => 41,
                'party_id' => 41
            ]
        );
    }
}
