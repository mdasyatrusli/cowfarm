<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthRecord extends Model
{
    /** @use HasFactory<\Database\Factories\HealthRecordFactory> */
    use HasFactory, BelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cow_id',
        'farm_id',
        'record_date',
        'diagnosis',
        'treatment',
        'vet_name',
        'cost',
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
            'cost' => 'decimal:2',
        ];
    }

    /**
     * Get the cow that the health record belongs to.
     */
    public function cow(): BelongsTo
    {
        return $this->belongsTo(Cow::class);
    }

    /**
     * Get the farm that the health record belongs to.
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
