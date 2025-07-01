<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['id' => 1, 'name' => 'Не протестировано'],
            ['id' => 2, 'name' => 'Пройден'],
            ['id' => 3, 'name' => 'Провален'],
            ['id' => 4, 'name' => 'Пропущен'],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
