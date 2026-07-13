<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class FeedRecord extends Model
{
    /** @use HasFactory<\Database\Factories\FeedRecordFactory> */
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cow_id',
        'feed_id',
        'farm_id',
        'record_date',
        'quantity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'record_date' => 'date',
        ];
    }

    /**
     * Auto-create a FeedStockLog with type 'out' when a feed record is created.
     * This ensures stock is automatically deducted when feed is given to a cow.
     */
    protected static function booted(): void
    {
        static::created(function (FeedRecord $feedRecord) {
            DB::transaction(function () use ($feedRecord) {
                FeedStockLog::create([
                    'feed_id'  => $feedRecord->feed_id,
                    'farm_id'  => $feedRecord->farm_id,
                    'type'     => 'out',
                    'quantity' => $feedRecord->quantity,
                    'note'     => 'Pemberian pakan ke ' . ($feedRecord->cow->tag_number ?? 'unknown'),
                    'log_date' => $feedRecord->record_date,
                ]);
            });
        });
    }

    /**
     * Get the cow that this feed record belongs to.
     */
    public function cow(): BelongsTo
    {
        return $this->belongsTo(Cow::class);
    }

    /**
     * Get the feed that this feed record belongs to.
     */
    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class);
    }

    /**
     * Get the farm that this feed record belongs to.
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
