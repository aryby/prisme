<?php

namespace Tests\Feature;

use App\Filament\Resources\PaperResource\Pages\EditPaper;
use App\Mail\PaperCertificate;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PaperCertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_email_a_pdf_certificate_to_the_paper_author(): void
    {
        Storage::fake('local');
        Mail::fake();

        $author = User::factory()->create(['role' => 'author']);
        $admin = User::factory()->create(['role' => 'admin']);
        $paper = $this->createPaper($author);

        Livewire::actingAs($admin)
            ->test(EditPaper::class, ['record' => $paper->getRouteKey()])
            ->assertActionExists('sendCertificate')
            ->callAction('sendCertificate', [
                'email_subject' => 'Congratulations from PRISME',
                'email_message' => "Congratulations!\nYour certificate is attached.",
                'certificate' => UploadedFile::fake()->createWithContent(
                    'certificate.pdf',
                    "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n",
                ),
            ])
            ->assertHasNoActionErrors();

        $paper->refresh();
        $this->assertNotEmpty($paper->certificate_path);
        $this->assertNotNull($paper->certificate_sent_at);
        Storage::disk('local')->assertExists($paper->certificate_path);

        Mail::assertSent(PaperCertificate::class, function (PaperCertificate $mail) use ($author, $paper): bool {
            $mail->build();
            $content = $mail->render();

            return $mail->hasTo($author->email)
                && $mail->paper->is($paper)
                && $mail->emailSubject === 'Congratulations from PRISME'
                && $mail->emailMessage === "Congratulations!\nYour certificate is attached."
                && str_contains($content, 'Congratulations!')
                && str_contains($content, 'Your certificate is attached.')
                && $mail->hasAttachmentFromStorageDisk(
                    'local',
                    $paper->certificate_path,
                    'PRISME-2026-Certificate-'.str()->slug($author->name).'.pdf',
                    ['mime' => 'application/pdf'],
                );
        });
    }

    public function test_author_can_download_own_certificate_but_not_another_authors(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('certificates/author-certificate.pdf', "%PDF-1.4\n");

        $author = User::factory()->create(['role' => 'author']);
        $paper = $this->createPaper($author, [
            'certificate_path' => 'certificates/author-certificate.pdf',
        ]);

        $this->actingAs($author)
            ->get(route('filament.author.resources.papers.index'))
            ->assertOk()
            ->assertSee('Download certificate');

        $this->actingAs($author)
            ->get(route('author.papers.certificate', $paper))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf')
            ->assertHeader(
                'content-disposition',
                'attachment; filename=PRISME-2026-Certificate-'.str()->slug($author->name).'.pdf',
            );

        $otherAuthor = User::factory()->create(['role' => 'author']);

        $this->actingAs($otherAuthor)
            ->get(route('author.papers.certificate', $paper))
            ->assertNotFound();
    }

    public function test_author_cannot_download_certificate_before_admin_sends_it(): void
    {
        $author = User::factory()->create(['role' => 'author']);
        $paper = $this->createPaper($author);

        $this->actingAs($author)
            ->get(route('author.papers.certificate', $paper))
            ->assertNotFound();
    }

    private function createPaper(User $author, array $attributes = []): Paper
    {
        return Paper::create($attributes + [
            'author_id' => $author->id,
            'title' => 'Certificate test paper',
            'abstract' => 'Test abstract.',
            'keywords' => 'test',
            'track' => 'AI',
            'submission_option' => 'full_submission',
            'status' => 'accepted',
        ]);
    }
}
