<?php

namespace App\Providers;

use App\Models\Breed;
use App\Models\Farm;
use App\Models\User;
use App\Policies\BreedPolicy;
use App\Policies\FarmPolicy;
use App\Policies\StaffPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Farm::class => FarmPolicy::class,
        Breed::class => BreedPolicy::class,
        User::class => StaffPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
