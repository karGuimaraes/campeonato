<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('games')->insert(
            [
                ['name' => 'Counter Strike 2', 'type' => 'FPS'],
                ['name' => 'Valorant', 'type' => 'FPS'],
                ['name' => 'League of Legends', 'type' => 'MOBA'],
            ]
        );
    }
}
