<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Season;

class SeasonSeeder extends Seeder
{
    public function run(): void
    {
        // 春・夏・秋・冬 の4つの季節を棚に並べるよ！
        Season::create(['name' => '春']);
        Season::create(['name' => '夏']);
        Season::create(['name' => '秋']);
        Season::create(['name' => '冬']);
    }
}
