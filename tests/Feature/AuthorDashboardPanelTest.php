<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorDashboardPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_panel_redirects_to_login_when_not_authenticated(): void
    {
        $this->get('/author')
            ->assertRedirect('/author/login');
    }

    public function test_author_user_is_forbidden_from_admin_panel(): void
    {
        $user = \App\Models\User::factory()->create([
            'role' => 'author',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_admin_user_is_forbidden_from_author_panel(): void
    {
        $user = \App\Models\User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get('/author/dashboard')
            ->assertForbidden();
    }

    public function test_author_sees_only_her_own_papers_in_author_dashboard(): void
    {
        $author = \App\Models\User::factory()->create([
            'role' => 'author',
            'is_active' => true,
        ]);

        $otherAuthor = \App\Models\User::factory()->create([
            'role' => 'author',
            'is_active' => true,
        ]);

        \App\Models\Paper::create([
            'author_id' => $author->id,
            'title' => 'My paper',
            'abstract' => 'Lorem ipsum',
            'keywords' => 'demo, test',
            'track' => 'AI',
            'submission_option' => 'full_submission',
            'affiliation' => 'Test University',
            'country' => 'FR',
            'phone' => '123456',
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        \App\Models\Paper::create([
            'author_id' => $otherAuthor->id,
            'title' => 'Other author paper',
            'abstract' => 'Another abstract',
            'keywords' => 'demo, other',
            'track' => 'AI',
            'submission_option' => 'full_submission',
            'affiliation' => 'Other University',
            'country' => 'US',
            'phone' => '654321',
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        $this->actingAs($author)
            ->get('/author/dashboard/papers')
            ->assertOk()
            ->assertSee('My paper')
            ->assertDontSee('Other author paper');
    }
}
