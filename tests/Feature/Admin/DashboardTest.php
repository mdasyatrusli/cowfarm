<?php

namespace Tests\Feature\Admin;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
            'farm_id' => null,
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    public function test_admin_farm_cannot_access_admin_dashboard(): void
    {
        $farm = Farm::factory()->create();
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN_FARM,
            'farm_id' => $farm->id,
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_worker_cannot_access_admin_dashboard(): void
    {
        $farm = Farm::factory()->create();
        $user = User::factory()->create([
            'role' => User::ROLE_WORKER,
            'farm_id' => $farm->id,
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_super_admin_is_redirected_to_admin_dashboard_after_login(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
            'farm_id' => null,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_farm_is_redirected_to_user_dashboard_after_login(): void
    {
        $farm = Farm::factory()->create();
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN_FARM,
            'farm_id' => $farm->id,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

    public function test_worker_is_redirected_to_user_dashboard_after_login(): void
    {
        $farm = Farm::factory()->create();
        $user = User::factory()->create([
            'role' => User::ROLE_WORKER,
            'farm_id' => $farm->id,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }
}
