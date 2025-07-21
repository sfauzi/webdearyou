<?php

namespace App\Console\Commands;

use App\Models\Confession;
use App\Services\SpotifyService;
use Illuminate\Console\Command;

class VerifySpotifyDataSync extends Command
{
    protected $signature = 'spotify:verify-sync {--limit=10 : Number of records to check}';
    protected $description = 'Verify that Spotify data is synchronized correctly';

    public function handle()
    {
        $limit = $this->option('limit');
        $spotifyService = new SpotifyService();

        $this->info("Checking {$limit} records for data synchronization...");
        $this->newLine();

        // Ambil sample data
        $records = Confession::take($limit)->get();

        $inconsistentCount = 0;
        $totalChecked = 0;

        foreach ($records as $record) {
            $totalChecked++;

            $this->info("Checking Record #{$record->id}:");
            $this->info("- Song ID: {$record->song_id}");
            $this->info("- Stored Title: {$record->song_title}");
            $this->info("- Stored Artist: {$record->song_artist}");

            try {
                // Ambil data real dari Spotify API
                $realData = $spotifyService->getTrack($record->song_id);

                if ($realData) {
                    $titleMatch = $record->song_title === $realData['title'];
                    $artistMatch = $record->song_artist === $realData['artist'];
                    $imageMatch = $record->song_image === $realData['image'];

                    if (!$titleMatch || !$artistMatch || !$imageMatch) {
                        $inconsistentCount++;
                        $this->error("❌ INCONSISTENT DATA FOUND!");

                        if (!$titleMatch) {
                            $this->warn("  Title mismatch: '{$record->song_title}' vs '{$realData['title']}'");
                        }
                        if (!$artistMatch) {
                            $this->warn("  Artist mismatch: '{$record->song_artist}' vs '{$realData['artist']}'");
                        }
                        if (!$imageMatch) {
                            $this->warn("  Image mismatch");
                        }
                    } else {
                        $this->info("✅ Data is synchronized correctly");
                    }
                } else {
                    $this->warn("⚠️  Could not fetch data from Spotify API for ID: {$record->song_id}");
                }
            } catch (\Exception $e) {
                $this->error("❌ API Error: " . $e->getMessage());
            }

            $this->newLine();
        }

        // Summary
        $this->info("=== VERIFICATION SUMMARY ===");
        $this->info("Total records checked: {$totalChecked}");
        $this->info("Inconsistent records: {$inconsistentCount}");
        $this->info("Consistency rate: " . round((($totalChecked - $inconsistentCount) / $totalChecked) * 100, 2) . "%");

        if ($inconsistentCount === 0) {
            $this->info("🎉 All data is perfectly synchronized!");
        } else {
            $this->warn("⚠️  Found {$inconsistentCount} inconsistent records. Consider regenerating the data.");
        }

        return $inconsistentCount === 0 ? 0 : 1;
    }
}
