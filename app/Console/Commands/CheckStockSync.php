<?php

namespace App\Console\Commands;

use App\Models\Feed;
use Illuminate\Console\Command;

class CheckStockSync extends Command
{
    protected $signature = 'check:stock-sync';
    protected $description = 'Check if current_stock in feeds table matches feed_stock_logs calculations';

    public function handle()
    {
        $feeds = Feed::with('stockLogs')->get();

        $headers = ['Feed Name', 'current_stock (DB)', 'Total IN', 'Total OUT', 'LogCalc (IN-OUT)', 'Status'];
        $rows = [];

        foreach ($feeds as $f) {
            $totalIn = $f->stockLogs->where('type', 'in')->sum('quantity');
            $totalOut = $f->stockLogs->where('type', 'out')->sum('quantity');
            $logCalc = $totalIn - $totalOut;
            $dbStock = $f->current_stock;
            $match = ($dbStock == $logCalc) ? '✓ SINKRON' : '✗ TIDAK SINKRON';
            $rows[] = [$f->name, $dbStock, $totalIn, $totalOut, $logCalc, $match];
        }

        $this->table($headers, $rows);
    }
}
