<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SharedLoginPageTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_route_uses_a_single_shared_page(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertViewIs('auth.login');
    }

    public function test_admin_user_is_redirected_to_admin_dashboard_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'admin-login@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
    }

    public function test_author_user_is_redirected_to_author_dashboard_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'author-login@example.com',
            'password' => Hash::make('password123'),
            'role' => 'author',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/author/dashboard');
    }

    public function test_reviewer_user_is_redirected_to_reviewer_dashboard_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'reviewer-login@example.com',
            'password' => Hash::make('password123'),
            'role' => 'reviewer',
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/reviewer/dashboard');
    }
}
