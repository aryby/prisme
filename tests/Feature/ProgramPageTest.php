<?php

namespace Tests\Feature;

use App\Filament\Pages\EditProgramPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProgramPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_edit_program_page_with_rich_text(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->get(route('program'))
            ->assertOk()
            ->assertSee('Coming Soon')
            ->assertSeeInOrder(['PROGRAM', 'VENUE']);

        $this->actingAs($admin)
            ->get(EditProgramPage::getUrl())
            ->assertOk()
            ->assertSee('Program Page')
            ->assertSee('Program content');

        Livewire::actingAs($admin)
            ->test(EditProgramPage::class)
            ->fillForm([
                'title' => 'SIPRISME 2026 Program',
                'description' => 'Explore the updated symposium schedule.',
                'content' => '<h2>Program schedule</h2><p>Opening keynote <strong>details</strong>.</p><script>alert(1)</script>',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('page_contents', [
            'key' => 'program.title',
            'content' => 'SIPRISME 2026 Program',
        ]);
        $this->assertDatabaseHas('page_contents', [
            'key' => 'program.description',
            'content' => 'Explore the updated symposium schedule.',
        ]);
        $this->assertDatabaseHas('page_contents', [
            'key' => 'program.page',
            'content' => '<h2>Program schedule</h2><p>Opening keynote <strong>details</strong>.</p>',
        ]);

        $this->get(route('program'))
            ->assertOk()
            ->assertSee('<title>SIPRISME 2026 Program</title>', false)
            ->assertSee('<meta name="description" content="Explore the updated symposium schedule.">', false)
            ->assertSee('Program schedule')
            ->assertSee('<strong>details</strong>', false)
            ->assertDontSee('<script>', false);
    }

    public function test_non_admin_cannot_access_program_page_editor(): void
    {
        $author = User::factory()->create(['role' => 'author']);

        $this->actingAs($author)
            ->get(EditProgramPage::getUrl())
            ->assertForbidden();
    }
}
