<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class FeedStockLog extends Model
{
    /** @use HasFactory<\Database\Factories\FeedStockLogFactory> */
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'feed_id',
        'farm_id',
        'type',
        'quantity',
        'note',
        'log_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'log_date' => 'date',
        ];
    }

    /**
     * Auto-update the feed's current_stock when a stock log is created, updated, or deleted.
     */
    protected static function booted(): void
    {
        static::created(function (FeedStockLog $log) {
            DB::transaction(function () use ($log) {
                $feed = $log->feed;

                if ($log->type === 'in') {
                    $feed->increment('current_stock', $log->quantity, []);
                } else {
                    $feed->decrement('current_stock', $log->quantity, []);
                }
            });
        });

        static::updated(function (FeedStockLog $log) {
            DB::transaction(function () use ($log) {
                $feed = $log->feed;
                $original = $log->getOriginal();

                // Reverse the old stock change
                if ($original['type'] === 'in') {
                    $feed->decrement('current_stock', $original['quantity'], []);
                } else {
                    $feed->increment('current_stock', $original['quantity'], []);
                }

                // Apply the new stock change
                if ($log->type === 'in') {
                    $feed->increment('current_stock', $log->quantity, []);
                } else {
                    $feed->decrement('current_stock', $log->quantity, []);
                }
            });
        });

        static::deleted(function (FeedStockLog $log) {
            DB::transaction(function () use ($log) {
                $feed = $log->feed;

                // Reverse the stock change
                if ($log->type === 'in') {
                    $feed->decrement('current_stock', $log->quantity, []);
                } else {
                    $feed->increment('current_stock', $log->quantity, []);
                }
            });
        });
    }

    /**
     * Get the feed that this stock log belongs to.
     */
    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }

    /**
     * Get the farm that this stock log belongs to.
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
