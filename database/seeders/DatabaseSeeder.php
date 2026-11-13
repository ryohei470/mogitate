<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ★ここに「作った2つの注文書を順番に実行してね！」と教える大魔法を書くよ！
        $this->call([
            SeasonSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
