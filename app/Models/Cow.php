<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cow extends Model
{
    /** @use HasFactory<\Database\Factories\CowFactory> */
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'farm_id',
        'tag_number',
        'name',
        'breed_id',
        'gender',
        'birth_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    /**
     * Get the farm that the cow belongs to.
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    /**
     * Get the breed that the cow belongs to.
     */
    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    /**
     * Get the health records for the cow.
     */
    public function healthRecords(): HasMany
    {
        return $this->hasMany(HealthRecord::class);
    }

    /**
     * Get the milk records for the cow.
     */
    public function milkRecords(): HasMany
    {
        return $this->hasMany(MilkRecord::class);
    }

    /**
     * Get the feed records for the cow.
     */
    public function feedRecords(): HasMany
    {
        return $this->hasMany(FeedRecord::class);
    }
}
