<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Farm extends Model
{
    /** @use HasFactory<\Database\Factories\FarmFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'location',
        'owner_id',
    ];

    /**
     * Get the owner of the farm.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the users belonging to this farm.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the cows for this farm.
     */
    public function cows(): HasMany
    {
        return $this->hasMany(Cow::class);
    }

    /**
     * Get the health records for this farm.
     */
    public function healthRecords(): HasMany
    {
        return $this->hasMany(HealthRecord::class);
    }

    /**
     * Get the milk records for this farm.
     */
    public function milkRecords(): HasMany
    {
        return $this->hasMany(MilkRecord::class);
    }

    /**
     * Get the feeds (jenis pakan) for this farm.
     */
    public function feeds(): HasMany
    {
        return $this->hasMany(Feed::class);
    }

    /**
     * Get the feed stock logs for this farm.
     */
    public function feedStockLogs(): HasMany
    {
        return $this->hasMany(FeedStockLog::class);
    }

    /**
     * Get the transactions for this farm.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
