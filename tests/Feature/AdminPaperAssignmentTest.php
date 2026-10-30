<?php

namespace Tests\Feature;

use App\Filament\Resources\PaperResource\Pages\EditPaper;
use App\Mail\ReviewerPaperAssigned;
use App\Models\Paper;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPaperAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_assign_reviewer_from_paper_edit_and_assignment_email_is_sent(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $author = User::factory()->create([
            'role' => 'author',
        ]);
        $reviewer = User::factory()->create([
            'name' => 'Paper Reviewer',
            'email' => 'paper-reviewer@example.com',
            'role' => 'reviewer',
        ]);
        $paper = $this->createPaper($author);

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
                'reviews' => [
                    ['reviewer_id' => $reviewer->id],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $review = Review::query()->where('paper_id', $paper->id)->firstOrFail();
        $this->assertSame($reviewer->id, $review->reviewer_id);

        Mail::assertSent(ReviewerPaperAssigned::class, function (ReviewerPaperAssigned $mail) use ($reviewer, $paper): bool {
            $content = $mail->render();

            return $mail->hasTo($reviewer->email)
                && $mail->review->paper->is($paper)
                && str_contains($content, $paper->title)
                && str_contains($content, route('reviewer.reviews.paper', ['review' => $mail->review]));
        });
    }

    public function test_admin_can_preview_paper_pdf_but_other_roles_cannot(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('papers/test.pdf', '%PDF-1.4 test');

        $author = User::factory()->create([
            'role' => 'author',
        ]);
        $paper = $this->createPaper($author);
        $paper->update(['file_path' => 'papers/test.pdf']);

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('filament.admin.resources.papers.edit', ['record' => $paper]))
            ->assertOk()
            ->assertSee('View PDF');

        $this->actingAs($admin)
            ->get(route('admin.papers.pdf', $paper))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');

        $this->actingAs($author)
            ->get(route('admin.papers.pdf', $paper))
            ->assertForbidden();
    }

    private function createPaper(User $author): Paper
    {
        return Paper::create([
            'author_id' => $author->id,
            'title' => 'A paper to review',
            'abstract' => 'Detailed research abstract.',
            'keywords' => 'research, review',
            'track' => 'AI',
            'submission_option' => 'full_submission',
            'file_path' => 'papers/paper.pdf',
            'status' => 'under_review',
            'submitted_at' => now(),
        ]);
    }
}
