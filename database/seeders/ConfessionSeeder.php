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
        // Generate 1000 records dengan progress indication
        $totalRecords = 1000;
        $batchSize = 100;
        $batches = ceil($totalRecords / $batchSize);

        $this->command->info("Generating {$totalRecords} records in {$batches} batches...");

        for ($i = 0; $i < $batches; $i++) {
            $currentBatch = $i + 1;
            $recordsInThisBatch = min($batchSize, $totalRecords - ($i * $batchSize));

            Confession::factory()
                ->count($recordsInThisBatch)
                ->create();

            $this->command->info("Batch {$currentBatch}/{$batches} completed ({$recordsInThisBatch} records)");
        }

        $this->command->info("Successfully generated {$totalRecords} records!");
        // Confession::factory()->count(50)->create();
    }
}
