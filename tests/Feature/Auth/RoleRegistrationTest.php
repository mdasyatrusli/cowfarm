<?php

namespace Tests\Feature\Auth;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_farm_register_creates_farm_and_sets_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Farm Admin',
            'email' => 'farmadmin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => User::ROLE_ADMIN_FARM,
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();

        $user = User::where('email', 'farmadmin@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals(User::ROLE_ADMIN_FARM, $user->role);
        $this->assertNotNull($user->farm_id);

        // Verify a farm was created with this user as owner
        $farm = Farm::find($user->farm_id);
        $this->assertNotNull($farm);
        $this->assertEquals($user->id, $farm->owner_id);
        $this->assertStringContainsString($user->name, $farm->name);
    }

    public function test_worker_register_does_not_create_farm(): void
    {
        $response = $this->post('/register', [
            'name' => 'Worker',
            'email' => 'worker@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => User::ROLE_WORKER,
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();

        $user = User::where('email', 'worker@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals(User::ROLE_WORKER, $user->role);
        $this->assertNull($user->farm_id);
    }

    public function test_default_role_is_admin_farm(): void
    {
        $response = $this->post('/register', [
            'name' => 'Default Role User',
            'email' => 'default@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();

        $user = User::where('email', 'default@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals(User::ROLE_ADMIN_FARM, $user->role);
        $this->assertNotNull($user->farm_id);
    }
}
