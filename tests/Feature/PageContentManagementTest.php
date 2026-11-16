<?php

namespace Tests\Feature;

use App\Filament\Resources\PageContentResource\Pages\EditPageContent;
use App\Filament\Resources\PageContentResource\Pages\ListPageContents;
use App\Models\PageContent;
use App\Models\User;
use Database\Seeders\PageContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PageContentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_static_page_text_and_see_it_on_the_public_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $content = PageContent::query()->where('key', 'about.intro')->firstOrFail();
        $updatedText = 'Updated SIPRISME introduction';

        $this->assertSame(config('page-content')['about.intro']['default'], PageContent::text('about.intro'));

        Livewire::actingAs($admin)
            ->test(EditPageContent::class, ['record' => $content->getRouteKey()])
            ->fillForm(['content' => $updatedText])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame($updatedText, PageContent::text('about.intro'));

        $this->get(route('about'))
            ->assertOk()
            ->assertSee($updatedText);
    }

    public function test_non_admin_cannot_manage_static_page_content(): void
    {
        $user = User::factory()->create(['role' => 'author']);

        Livewire::actingAs($user)
            ->test(ListPageContents::class)
            ->assertForbidden();
    }

    public function test_page_content_seeder_adds_missing_defaults_without_overwriting_customized_text(): void
    {
        PageContent::query()
            ->where('key', 'about.intro')
            ->update(['content' => 'Customized introduction']);
        PageContent::query()
            ->where('key', 'about.overview')
            ->delete();

        $this->seed(PageContentSeeder::class);

        $this->assertDatabaseHas('page_contents', [
            'key' => 'about.intro',
            'content' => 'Customized introduction',
        ]);
        $this->assertDatabaseHas('page_contents', [
            'key' => 'about.overview',
            'content' => config('page-content')['about.overview']['default'],
        ]);
    }
}
