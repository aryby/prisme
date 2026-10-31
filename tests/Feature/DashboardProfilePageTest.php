<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_dashboard_role_can_access_its_profile_page(): void
    {
        $profiles = [
            ['admin', '/admin/profile'],
            ['author', '/author/dashboard/profile'],
            ['reviewer', '/reviewer/dashboard/profile'],
        ];

        foreach ($profiles as [$role, $path]) {
            $user = User::factory()->create(['role' => $role]);

            $this->actingAs($user)
                ->get($path)
                ->assertOk()
                ->assertSee('name')
                ->assertSee('email')
                ->assertSee('password')
                ->assertSee('Submit')
                ->assertDontSee('Save changes');
        }
    }
}
