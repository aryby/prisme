<?php

namespace Tests\Feature;

use App\Filament\Pages\EditCommitteePage;
use App\Filament\Pages\EditSiteAppearance;
use App\Filament\Resources\ImportantDateResource\Pages\CreateImportantDate;
use App\Filament\Resources\ImportantDateResource\Pages\EditImportantDate;
use App\Filament\Resources\PageContentResource\Pages\EditPageContent;
use App\Filament\Widgets\SubmissionSettingsWidget;
use App\Models\ImportantDate;
use App\Models\PageContent;
use App\Models\User;
use Database\Seeders\CommitteePageSeeder;
use Database\Seeders\ImportantDateSeeder;
use Database\Seeders\SiteAppearanceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class WebsiteSubmissionAndDatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_close_public_paper_submissions(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $setting = PageContent::query()->where('key', 'submission.enabled')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(EditPageContent::class, ['record' => $setting->getRouteKey()])
            ->fillForm(['content' => false])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertFalse(PageContent::submissionsEnabled());

        $this->get(route('submission'))
            ->assertOk()
            ->assertSee('Paper submissions are currently closed.')
            ->assertDontSee('name="title"', false);

        $this->from(route('submission'))
            ->post(route('submission.store'), [])
            ->assertRedirect(route('submission'))
            ->assertSessionHas('submission_closed');

        $this->assertDatabaseCount('papers', 0);
    }

    public function test_admin_can_edit_committee_page_from_its_dedicated_admin_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->get(route('committee'))
            ->assertOk()
            ->assertSee('Honorary Committee')
            ->assertSee('Organizing Committee')
            ->assertSee('Scientific Committee')
            ->assertSee('Pr. AHSINA');

        $this->actingAs($admin)
            ->get(EditCommitteePage::getUrl())
            ->assertOk()
            ->assertSee('Committee Page')
            ->assertSee('Committee content');

        Livewire::actingAs($admin)
            ->test(EditCommitteePage::class)
            ->fillForm([
                'title' => 'Committee page from dedicated editor',
                'description' => 'Updated from the Committee Page menu.',
                'content' => '<h2>Committee editor test</h2><ul><li>Member</li></ul><script>alert(1)</script>',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->get(route('committee'))
            ->assertSee('<title>Committee page from dedicated editor</title>', false)
            ->assertSee('<meta name="description" content="Updated from the Committee Page menu.">', false)
            ->assertSee('Committee page from dedicated editor')
            ->assertSee('Committee editor test')
            ->assertSee('Member')
            ->assertDontSee('<script>', false);
    }

    public function test_non_admin_cannot_access_committee_page_editor(): void
    {
        $author = User::factory()->create(['role' => 'author']);

        $this->actingAs($author)
            ->get(EditCommitteePage::getUrl())
            ->assertForbidden();
    }

    public function test_admin_can_change_the_public_header_logo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin)
            ->test(EditSiteAppearance::class)
            ->set('data.logo', UploadedFile::fake()->image('new-logo.png'))
            ->fillForm([
                'header_title' => 'Updated SIPRISME header title',
                'header_details' => '20-21 December 2026 // Rabat, Morocco',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $logoPath = PageContent::query()->where('key', 'site.logo')->value('content');

        $this->assertIsString($logoPath);
        $this->assertStringStartsWith('site/', $logoPath);
        Storage::disk('public')->assertExists($logoPath);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('src="'.asset('storage/'.$logoPath).'"', false)
            ->assertDontSee('src="'.asset('img/logo/lgo.jpg').'"', false)
            ->assertSee('Updated SIPRISME header title')
            ->assertSee('20-21 December 2026 // Rabat, Morocco');
    }

    public function test_non_admin_cannot_access_site_appearance_settings(): void
    {
        $author = User::factory()->create(['role' => 'author']);

        $this->actingAs($author)
            ->get(EditSiteAppearance::getUrl())
            ->assertForbidden();
    }

    public function test_site_appearance_seeder_adds_missing_logo_setting_without_overwriting_admin_logo(): void
    {
        PageContent::query()->where('key', 'site.logo')->update([
            'content' => 'site/custom-logo.png',
        ]);

        $this->seed(SiteAppearanceSeeder::class);

        $this->assertDatabaseHas('page_contents', [
            'key' => 'site.logo',
            'content' => 'site/custom-logo.png',
        ]);

        PageContent::query()->where('key', 'site.logo')->delete();
        PageContent::query()->whereIn('key', ['site.header-title', 'site.header-details'])->delete();
        $this->seed(SiteAppearanceSeeder::class);

        $this->assertDatabaseHas('page_contents', [
            'key' => 'site.logo',
            'label' => config('page-content')['site.logo']['label'],
            'content' => '',
        ]);
        $this->assertDatabaseHas('page_contents', [
            'key' => 'site.header-title',
            'content' => config('page-content')['site.header-title']['default'],
        ]);
        $this->assertDatabaseHas('page_contents', [
            'key' => 'site.header-details',
            'content' => config('page-content')['site.header-details']['default'],
        ]);
    }

    public function test_committee_page_migration_preserves_existing_organizing_committee_edits(): void
    {
        PageContent::query()->where('key', 'committee.page')->delete();

        PageContent::query()->create([
            'key' => 'committee.organizing',
            'label' => 'Committee organizing',
            'content' => 'Prof. Updated Committee Member',
        ]);

        $migration = require database_path('migrations/2026_11_16_000003_add_committee_page_content.php');
        $migration->up();

        $this->get(route('committee'))
            ->assertOk()
            ->assertSee('Prof. Updated Committee Member')
            ->assertDontSee('Prof. Hamid AMIFI');

        $this->assertDatabaseMissing('page_contents', ['key' => 'committee.organizing']);
    }

    public function test_committee_page_seeder_adds_missing_records_without_overwriting_edits(): void
    {
        PageContent::query()->where('key', 'committee.page')->update([
            'content' => '<h2>Admin edit</h2>',
        ]);
        PageContent::query()->where('key', 'committee.title')->delete();

        $this->seed(CommitteePageSeeder::class);

        $this->assertDatabaseHas('page_contents', [
            'key' => 'committee.page',
            'content' => '<h2>Admin edit</h2>',
        ]);
        $this->assertDatabaseHas('page_contents', [
            'key' => 'committee.title',
            'content' => config('page-content')['committee.title']['default'],
        ]);
        $this->assertDatabaseHas('page_contents', [
            'key' => 'committee.description',
            'content' => config('page-content')['committee.description']['default'],
        ]);
    }

    public function test_admin_can_toggle_submissions_from_the_dashboard_widget(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('filament.admin.pages.dashboard'))
            ->assertOk();

        Livewire::actingAs($admin)
            ->test(SubmissionSettingsWidget::class)
            ->assertSee('Disable submissions')
            ->call('toggleSubmissions')
            ->assertSet('submissionsEnabled', false)
            ->assertSee('Enable submissions');

        $this->assertFalse(PageContent::submissionsEnabled());

        Livewire::actingAs($admin)
            ->test(SubmissionSettingsWidget::class)
            ->call('toggleSubmissions')
            ->assertSet('submissionsEnabled', true);

        $this->assertTrue(PageContent::submissionsEnabled());
    }

    public function test_non_admin_cannot_toggle_paper_submissions_from_the_dashboard_widget(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $this->actingAs($author);

        $this->assertFalse(SubmissionSettingsWidget::canView());

        try {
            (new SubmissionSettingsWidget)->toggleSubmissions();
            $this->fail('Non-admins must not be able to change paper submission settings.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
        }
    }

    public function test_admin_can_create_update_and_delete_public_important_dates(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin)
            ->test(CreateImportantDate::class)
            ->fillForm([
                'title' => 'Registration deadline',
                'date' => '10 December 2026',
                'sort_order' => 6,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $date = ImportantDate::query()->where('title', 'Registration deadline')->firstOrFail();

        $this->get(route('important-dates'))
            ->assertOk()
            ->assertSee('Registration deadline')
            ->assertSee('10 December 2026');

        Livewire::actingAs($admin)
            ->test(EditImportantDate::class, ['record' => $date->getRouteKey()])
            ->fillForm([
                'title' => 'Updated registration deadline',
                'date' => '12 December 2026',
                'sort_order' => 6,
                'is_active' => true,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->get(route('dates-news'))
            ->assertOk()
            ->assertSee('Updated registration deadline')
            ->assertSee('12 December 2026')
            ->assertDontSee('Registration deadline:');

        Livewire::actingAs($admin)
            ->test(EditImportantDate::class, ['record' => $date->getRouteKey()])
            ->callAction('delete')
            ->assertHasNoActionErrors();

        $this->assertDatabaseMissing('important_dates', ['id' => $date->id]);
    }

    public function test_important_date_seeder_adds_missing_defaults_without_overwriting_admin_changes(): void
    {
        $customizedDate = ImportantDate::query()
            ->where('key', 'abstract-submission-deadline')
            ->firstOrFail();
        $customizedDate->update(['date' => 'Updated by an admin']);

        ImportantDate::query()
            ->where('key', 'acceptance-notification')
            ->delete();

        $this->seed(ImportantDateSeeder::class);
        $this->seed(ImportantDateSeeder::class);

        $this->assertDatabaseHas('important_dates', [
            'key' => 'abstract-submission-deadline',
            'date' => 'Updated by an admin',
        ]);
        $this->assertDatabaseHas('important_dates', [
            'key' => 'acceptance-notification',
            'title' => 'Notification of acceptance',
            'date' => config('page-content')['important-dates.acceptance']['default'],
        ]);
        $this->assertDatabaseCount('important_dates', count(config('important-dates')));
    }
}
