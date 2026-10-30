<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationRemovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_routes_are_no_longer_available(): void
    {
        $this->get('/registration')->assertNotFound();
        $this->post('/registration')->assertNotFound();

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/admin/registrations')
            ->assertNotFound();
    }
}
