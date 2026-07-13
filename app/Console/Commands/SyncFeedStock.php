<?php

namespace App\Console\Commands;

use App\Models\Feed;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncFeedStock extends Command
{
    protected $signature = 'feed:sync-stock {--dry-run : Show what would be updated without actually updating}';
    protected $description = 'Sync current_stock in feeds table with feed_stock_logs calculations';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('🔍 DRY RUN MODE - No data will be updated');
            $this->newLine();
        }

        $feeds = Feed::with('stockLogs')->get();
        $syncedCount = 0;
        $alreadySyncedCount = 0;

        $headers = ['Feed ID', 'Feed Name', 'Current (DB)', 'Expected (Logs)', 'Diff', 'Action'];
        $rows = [];

        foreach ($feeds as $feed) {
            $totalIn = $feed->stockLogs->where('type', 'in')->sum('quantity');
            $totalOut = $feed->stockLogs->where('type', 'out')->sum('quantity');
            $expectedStock = $totalIn - $totalOut;
            $currentStock = $feed->current_stock;
            $diff = $currentStock - $expectedStock;

            if ($currentStock != $expectedStock) {
                $action = $isDryRun ? '⚠️  WOULD UPDATE' : '✅ UPDATED';

                if (!$isDryRun) {
                    DB::table('feeds')
                        ->where('id', $feed->id)
                        ->update(['current_stock' => $expectedStock]);
                }

                $syncedCount++;

                $rows[] = [
                    $feed->id,
                    $feed->name,
                    number_format($currentStock, 2),
                    number_format($expectedStock, 2),
                    number_format($diff, 2),
                    $action,
                ];
            } else {
                $alreadySyncedCount++;
            }
        }

        if (empty($rows)) {
            $this->info('✅ All feeds are already in sync!');
            $this->info("   Total feeds checked: {$feeds->count()}");
        } else {
            $this->table($headers, $rows);
            $this->newLine();

            if ($isDryRun) {
                $this->warn("⚠️  DRY RUN: {$syncedCount} feed(s) would be updated");
                $this->info("💡 Run without --dry-run to actually update the data:");
                $this->line("   php artisan feed:sync-stock");
            } else {
                $this->info("✅ Successfully synced {$syncedCount} feed(s)");
            }

            if ($alreadySyncedCount > 0) {
                $this->info("   {$alreadySyncedCount} feed(s) were already in sync");
            }
        }

        return 0;
    }
}
