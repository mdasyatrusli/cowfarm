<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the cows that belong to this breed.
     */
    public function cows()
    {
        return $this->hasMany(Cow::class);
    }
}
