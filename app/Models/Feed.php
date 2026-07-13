<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feed extends Model
{
    /** @use HasFactory<\Database\Factories\FeedFactory> */
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'farm_id',
        'name',
        'unit',
    ];

    /**
     * Get the farm that the feed belongs to.
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    /**
     * Get the stock logs for the feed.
     */
    public function stockLogs(): HasMany
    {
        return $this->hasMany(FeedStockLog::class);
    }

    /**
     * Get the feed records (pemberian pakan) for the feed.
     */
    public function feedRecords(): HasMany
    {
        return $this->hasMany(FeedRecord::class);
    }
}
