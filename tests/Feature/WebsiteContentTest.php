<?php

namespace Tests\Feature;

use App\Filament\Resources\PartnerLogoResource\Pages\CreatePartnerLogo;
use App\Filament\Resources\PartnerLogoResource\Pages\EditPartnerLogo;
use App\Filament\Resources\SlideResource\Pages\CreateSlide;
use App\Filament\Resources\SlideResource\Pages\EditSlide;
use App\Filament\Resources\SlideResource\Pages\ListSlides;
use App\Models\PartnerLogo;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class WebsiteContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_renders_active_slides_and_partner_logos_from_the_database(): void
    {
        $slide = Slide::query()->where('image', 'img/demo/slide1.jpg')->firstOrFail();
        $slide->update(['title' => 'Welcome slide']);

        Slide::query()->where('image', 'img/demo/slide2.jpg')->update(['is_active' => false]);
        PartnerLogo::query()->where('name', 'FSJES')->update(['url' => 'https://example.com']);
        PartnerLogo::query()->where('name', 'Massir')->update(['is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Welcome slide')
            ->assertSee(asset('img/demo/slide1.jpg'))
            ->assertDontSee(asset('img/demo/slide2.jpg'))
            ->assertSee('alt="FSJES"', false)
            ->assertSee('https://example.com')
            ->assertDontSee('alt="Massir"', false);
    }

    public function test_admin_homepage_navigation_links_to_the_filament_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('home'))
            ->assertOk()
            ->assertSee(route('filament.admin.pages.dashboard'))
            ->assertSee('ADMIN DASHBOARD');
    }

    public function test_admin_can_manage_slides_from_filament(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $slide = Slide::query()->where('image', 'img/demo/slide1.jpg')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(ListSlides::class)
            ->assertCanSeeTableRecords([$slide]);

        Livewire::actingAs($admin)
            ->test(EditSlide::class, ['record' => $slide->getRouteKey()])
            ->fillForm([
                'title' => 'Updated slide title',
                'caption' => 'Updated slide caption',
                'sort_order' => 5,
                'is_active' => false,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('slides', [
            'id' => $slide->id,
            'title' => 'Updated slide title',
            'caption' => 'Updated slide caption',
            'sort_order' => 5,
            'is_active' => false,
            'image' => 'img/demo/slide1.jpg',
        ]);
    }

    public function test_admin_can_upload_a_new_slide_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin)
            ->test(CreateSlide::class)
            ->fillForm([
                'image' => UploadedFile::fake()->image('new-slide.png')->size(3500),
                'title' => 'New slide',
                'caption' => 'A new homepage slide.',
                'sort_order' => 4,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $slide = Slide::query()->where('title', 'New slide')->firstOrFail();
        Storage::disk('public')->assertExists($slide->image);
        $this->assertSame(asset('storage/'.$slide->image), $slide->image_url);
    }

    public function test_livewire_temporary_upload_limit_allows_the_configured_slide_size(): void
    {
        $this->assertSame(
            ['required', 'file', 'max:16384'],
            config('livewire.temporary_file_upload.rules'),
        );
    }

    public function test_admin_can_manage_partner_logos_from_filament(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $partnerLogo = PartnerLogo::query()->where('name', 'FSJES')->firstOrFail();

        Livewire::actingAs($admin)
            ->test(EditPartnerLogo::class, ['record' => $partnerLogo->getRouteKey()])
            ->fillForm([
                'name' => 'Updated partner',
                'url' => 'https://example.com',
                'sort_order' => 8,
                'is_active' => false,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('partner_logos', [
            'id' => $partnerLogo->id,
            'name' => 'Updated partner',
            'url' => 'https://example.com',
            'sort_order' => 8,
            'is_active' => false,
            'image' => 'partnes/fsjes.jpg',
        ]);
    }

    public function test_admin_can_upload_a_partner_logo_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin)
            ->test(CreatePartnerLogo::class)
            ->fillForm([
                'name' => 'New partner',
                'image' => UploadedFile::fake()->image('partner-logo.png'),
                'url' => 'https://example.com',
                'sort_order' => 8,
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $partnerLogo = PartnerLogo::query()->where('name', 'New partner')->firstOrFail();
        Storage::disk('public')->assertExists($partnerLogo->image);
        $this->assertSame(asset('storage/'.$partnerLogo->image), $partnerLogo->image_url);
    }
}
