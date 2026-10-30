<?php

namespace Tests\Feature;

use App\Models\Paper;
use App\Models\User;
use App\Filament\Resources\PaperResource\Pages\CreatePaper;
use App\Filament\Resources\PaperResource\Pages\EditPaper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PaperPdfFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_submission_stores_pdf_privately_and_author_can_view_or_download_it(): void
    {
        Storage::fake('local');
        Mail::fake();
        Notification::fake();

        $this->post(route('submission.store'), [
            'submission_option' => 'full_submission',
            'title' => 'PDF submission',
            'track' => 'AI',
            'abstract' => 'A detailed research abstract.',
            'keywords' => 'research, pdf',
            'name' => 'Paper Author',
            'email' => 'pdf-author@example.com',
            'affiliation' => 'Example University',
            'country' => 'US',
            'phone' => '',
            'file' => UploadedFile::fake()->createWithContent(
                'submission.pdf',
                "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n",
            ),
            'originality' => '1',
            'copyright' => '1',
            'attendance' => '1',
        ])->assertRedirect(route('filament.author.pages.dashboard'));

        $paper = Paper::query()->where('title', 'PDF submission')->firstOrFail();
        $this->assertSame('local', $paper->file_disk);
        Storage::disk('local')->assertExists($paper->file_path);

        $author = User::query()->where('email', 'pdf-author@example.com')->firstOrFail();

        $this->actingAs($author)
            ->get(route('author.papers.pdf', $paper))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf')
            ->assertHeader('content-disposition', 'inline; filename='.basename($paper->file_path));

        $this->get(route('author.papers.pdf', $paper).'?download=1')
            ->assertOk()
            ->assertHeader('content-disposition', 'attachment; filename='.basename($paper->file_path));

        $otherAuthor = User::factory()->create(['role' => 'author']);
        $this->actingAs($otherAuthor)
            ->get(route('author.papers.pdf', $paper))
            ->assertNotFound();
    }

    public function test_admin_paper_form_uploads_pdf_to_private_storage(): void
    {
        Storage::fake('local');

        $admin = User::factory()->create(['role' => 'admin']);
        $author = User::factory()->create(['role' => 'author']);

        Livewire::actingAs($admin)
            ->test(CreatePaper::class)
            ->fillForm([
                'author_id' => $author->id,
                'title' => 'Filament upload',
                'abstract' => 'A detailed research abstract.',
                'keywords' => 'research, pdf',
                'track' => 'AI',
                'submission_option' => 'full_submission',
                'status' => 'submitted',
                'paper_upload' => UploadedFile::fake()->createWithContent(
                    'filament-upload.pdf',
                    "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n",
                ),
                'reviews' => [],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $paper = Paper::query()->where('title', 'Filament upload')->firstOrFail();
        $this->assertSame('local', $paper->file_disk);
        Storage::disk('local')->assertExists($paper->file_path);
    }

    public function test_admin_can_replace_an_existing_pdf_with_a_private_upload(): void
    {
        Storage::fake('local');
        Storage::fake('public');
        Storage::disk('public')->put('papers/old.pdf', "%PDF-1.4\n");

        $admin = User::factory()->create(['role' => 'admin']);
        $author = User::factory()->create(['role' => 'author']);
        $paper = Paper::create([
            'author_id' => $author->id,
            'title' => 'Replace PDF',
            'abstract' => 'A detailed research abstract.',
            'keywords' => 'research, pdf',
            'track' => 'AI',
            'submission_option' => 'full_submission',
            'file_path' => 'papers/old.pdf',
            'file_disk' => 'public',
            'status' => 'submitted',
        ]);

        Livewire::actingAs($admin)
            ->test(EditPaper::class, ['record' => $paper->getRouteKey()])
            ->fillForm([
                'author_id' => $author->id,
                'title' => $paper->title,
                'abstract' => $paper->abstract,
                'keywords' => $paper->keywords,
                'track' => $paper->track,
                'submission_option' => $paper->submission_option,
                'status' => $paper->status,
                'paper_upload' => UploadedFile::fake()->createWithContent(
                    'replacement.pdf',
                    "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n",
                ),
                'reviews' => [],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $paper->refresh();
        $this->assertSame('local', $paper->file_disk);
        $this->assertNotSame('papers/old.pdf', $paper->file_path);
        Storage::disk('local')->assertExists($paper->file_path);
    }
}
