<?php

namespace Tests\Feature;

use App\Filament\Resources\PaperResource\Pages\CreatePaper;
use App\Filament\Resources\PaperResource\Pages\EditPaper;
use App\Mail\SubmissionConfirmation;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
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
        Mail::assertQueued(SubmissionConfirmation::class, function (SubmissionConfirmation $mail) use ($paper): bool {
            $content = $mail->render();

            return $mail->paper->is($paper)
                && $mail->password !== null
                && str_contains($content, 'PDF submission')
                && str_contains($content, $mail->password)
                && str_contains($content, 'Example University');
        });

        Mail::assertQueued(SubmissionConfirmation::class, function (SubmissionConfirmation $mail) use ($author): bool {
            return $mail->password !== null && Hash::check($mail->password, $author->password);
        });

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

    public function test_existing_author_receives_submission_details_without_password_reset(): void
    {
        Storage::fake('local');
        Mail::fake();

        $author = User::factory()->create([
            'email' => 'returning-author@example.com',
            'role' => 'author',
        ]);
        $originalPassword = $author->password;

        $this->post(route('submission.store'), [
            'submission_option' => 'abstract_submission',
            'title' => 'Returning author submission',
            'track' => 'Digital Transformation and Artificial Intelligence',
            'abstract' => 'An abstract from a returning author.',
            'keywords' => 'returning, author',
            'name' => $author->name,
            'email' => $author->email,
            'affiliation' => 'Example Institute',
            'country' => 'US',
            'phone' => '',
            'file' => UploadedFile::fake()->createWithContent(
                'returning-submission.pdf',
                "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n",
            ),
            'originality' => '1',
            'copyright' => '1',
            'attendance' => '1',
        ])->assertRedirect(route('filament.author.pages.dashboard'));

        $this->assertSame($originalPassword, $author->fresh()->password);
        Mail::assertQueued(SubmissionConfirmation::class, function (SubmissionConfirmation $mail): bool {
            $content = $mail->render();

            return $mail->password === null
                && str_contains($content, 'Returning author submission')
                && str_contains($content, 'existing account')
                && ! str_contains($content, 'Temporary password');
        });
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
