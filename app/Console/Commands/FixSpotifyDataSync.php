<?php

namespace App\Console\Commands;

use App\Models\Confession;
use App\Services\SpotifyService;
use Illuminate\Console\Command;

class FixSpotifyDataSync extends Command
{
    protected $signature = 'spotify:fix-sync {--dry-run : Preview changes without applying them}';
    protected $description = 'Fix unsynchronized Spotify data';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $spotifyService = new SpotifyService();

        $this->info($dryRun ? "DRY RUN: Previewing fixes..." : "Fixing unsynchronized data...");
        $this->newLine();

        $records = Confession::all();
        $fixedCount = 0;
        $errorCount = 0;

        foreach ($records as $record) {
            try {
                $realData = $spotifyService->getTrack($record->song_id);

                if ($realData) {
                    $needsUpdate = false;
                    $changes = [];

                    if ($record->song_title !== $realData['title']) {
                        $changes['song_title'] = $realData['title'];
                        $needsUpdate = true;
                    }

                    if ($record->song_artist !== $realData['artist']) {
                        $changes['song_artist'] = $realData['artist'];
                        $needsUpdate = true;
                    }

                    if ($record->song_image !== $realData['image']) {
                        $changes['song_image'] = $realData['image'];
                        $needsUpdate = true;
                    }

                    if ($record->song_preview_url !== $realData['preview_url']) {
                        $changes['song_preview_url'] = $realData['preview_url'];
                        $needsUpdate = true;
                    }

                    if ($needsUpdate) {
                        $fixedCount++;
                        $this->info("Record #{$record->id} ({$record->song_id}):");

                        foreach ($changes as $field => $newValue) {
                            $oldValue = $record->$field;
                            $this->info("  {$field}: '{$oldValue}' -> '{$newValue}'");
                        }

                        if (!$dryRun) {
                            $record->update($changes);
                            $this->info("  ✅ Updated!");
                        } else {
                            $this->info("  📋 Would be updated (dry run)");
                        }

                        $this->newLine();
                    }
                }
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("Error fixing record #{$record->id}: " . $e->getMessage());
            }
        }

        $this->info("=== FIX SUMMARY ===");
        $this->info("Records that need fixing: {$fixedCount}");
        $this->info("Errors encountered: {$errorCount}");

        if ($dryRun && $fixedCount > 0) {
            $this->warn("Run without --dry-run to apply these fixes.");
        } elseif (!$dryRun && $fixedCount > 0) {
            $this->info("🎉 Successfully fixed {$fixedCount} records!");
        } else {
            $this->info("✅ No fixes needed - all data is synchronized!");
        }

        return 0;
    }
}
