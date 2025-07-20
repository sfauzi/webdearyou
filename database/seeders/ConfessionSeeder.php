<?php

namespace Database\Seeders;

use App\Models\Confession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Confession::factory()->count(1000)->create();
    }
}
