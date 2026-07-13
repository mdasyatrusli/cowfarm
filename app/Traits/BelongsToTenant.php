<?php

namespace App\Traits;

use App\Models\Farm;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    /**
     * A static flag per-model to prevent infinite recursion
     * when the global scope triggers an Auth::user() query
     * on a model that itself uses the same trait.
     */
    protected static bool $resolvingTenantScope = false;

    /**
     * Boot the BelongsToTenant trait.
     *
     * Registers a global scope on the model to automatically
     * filter queries by the currently authenticated user's farm_id.
     */
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('farm', function (Builder $builder) {
            if (static::$resolvingTenantScope) {
                return;
            }

            static::$resolvingTenantScope = true;

            try {
                $user = Auth::user();

                if ($user && !$user->isSuperAdmin()) {
                    $builder->where($builder->getModel()->getTable() . '.farm_id', $user->farm_id);
                }
            } finally {
                static::$resolvingTenantScope = false;
            }
        });

        static::creating(function (Model $model) {
            if (static::$resolvingTenantScope) {
                return;
            }

            static::$resolvingTenantScope = true;

            try {
                $user = Auth::user();

                if ($user && !$user->isSuperAdmin() && $user->farm_id && !$model->farm_id) {
                    $model->farm_id = $user->farm_id;
                }
            } finally {
                static::$resolvingTenantScope = false;
            }
        });
    }

    /**
     * Define the relationship to the farm (tenant).
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
