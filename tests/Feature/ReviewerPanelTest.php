<?php

namespace Tests\Feature;

use App\Filament\Resources\ReviewResource\Pages\EditReview;
use App\Filament\Widgets\ReviewerOverviewWidget;
use App\Models\Paper;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ReviewerPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_reviewer_can_access_the_reviewer_panel(): void
    {
        $reviewer = User::factory()->create([
            'role' => 'reviewer',
        ]);

        $this->actingAs($reviewer)
            ->get('/reviewer/dashboard')
            ->assertOk();
    }

    public function test_reviewer_dashboard_shows_only_their_review_statistics(): void
    {
        $reviewer = User::factory()->create(['role' => 'reviewer']);
        $otherReviewer = User::factory()->create(['role' => 'reviewer']);
        $author = User::factory()->create(['role' => 'author']);

        foreach (['pending', 'accepted', 'revision_required'] as $status) {
            Review::create([
                'paper_id' => $this->createPaper($author, "Paper for {$status}")->id,
                'reviewer_id' => $reviewer->id,
                'status' => $status,
            ]);
        }

        Review::create([
            'paper_id' => $this->createPaper($author, 'Other reviewer paper')->id,
            'reviewer_id' => $otherReviewer->id,
            'status' => 'pending',
        ]);

        $this->actingAs($reviewer)
            ->get('/reviewer/dashboard')
            ->assertOk();

        Livewire::actingAs($reviewer)
            ->test(ReviewerOverviewWidget::class)
            ->assertSee('Assigned reviews')
            ->assertSee('Pending reviews')
            ->assertSee('Completed reviews')
            ->assertSee('Recommend acceptance')
            ->assertSee('Recommend rejection')
            ->assertSee('Revision required')
            ->assertSee('3')
            ->assertSee('2')
            ->assertSee('1')
            ->assertSee('0');
    }

    public function test_reviewer_only_sees_and_can_open_assigned_reviews(): void
    {
        $reviewer = User::factory()->create([
            'role' => 'reviewer',
        ]);
        $otherReviewer = User::factory()->create([
            'role' => 'reviewer',
        ]);
        $author = User::factory()->create([
            'role' => 'author',
        ]);

        $assignedPaper = $this->createPaper($author, 'Assigned paper');
        $otherPaper = $this->createPaper($author, 'Other reviewer paper');

        $assignedReview = Review::create([
            'paper_id' => $assignedPaper->id,
            'reviewer_id' => $reviewer->id,
        ]);
        $otherReview = Review::create([
            'paper_id' => $otherPaper->id,
            'reviewer_id' => $otherReviewer->id,
        ]);

        $this->actingAs($reviewer)
            ->get('/reviewer/dashboard/reviews')
            ->assertOk()
            ->assertSee('Assigned paper')
            ->assertSee('Write review')
            ->assertDontSee('Other reviewer paper');

        $this->get("/reviewer/dashboard/reviews/{$assignedReview->id}/edit")
            ->assertOk()
            ->assertSee('Paper abstract')
            ->assertSee('View paper PDF');

        $this->get("/reviewer/dashboard/reviews/{$otherReview->id}/edit")
            ->assertNotFound();
    }

    public function test_reviewer_can_save_comments_score_and_decision_for_assigned_paper(): void
    {
        $reviewer = User::factory()->create([
            'role' => 'reviewer',
        ]);
        $author = User::factory()->create([
            'role' => 'author',
        ]);
        $paper = $this->createPaper($author, 'Paper to review');
        $review = Review::create([
            'paper_id' => $paper->id,
            'reviewer_id' => $reviewer->id,
        ]);

        Livewire::actingAs($reviewer)
            ->test(EditReview::class, ['record' => $review->getRouteKey()])
            ->fillForm([
                'status' => 'accepted',
                'score' => 4,
                'reviewComments' => [
                    ['body' => 'Strong paper; recommend acceptance.'],
                    ['body' => 'The methodology is clearly explained.'],
                ],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'reviewer_id' => $reviewer->id,
            'status' => 'accepted',
            'score' => 4,
        ]);
        $this->assertDatabaseHas('review_comments', [
            'review_id' => $review->id,
            'commenter_id' => $reviewer->id,
            'body' => 'Strong paper; recommend acceptance.',
        ]);
        $this->assertDatabaseHas('review_comments', [
            'review_id' => $review->id,
            'commenter_id' => $reviewer->id,
            'body' => 'The methodology is clearly explained.',
        ]);
    }

    public function test_reviewer_can_view_only_an_assigned_paper(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('papers/assigned.pdf', 'paper content');

        $reviewer = User::factory()->create([
            'role' => 'reviewer',
        ]);
        $otherReviewer = User::factory()->create([
            'role' => 'reviewer',
        ]);
        $author = User::factory()->create([
            'role' => 'author',
        ]);
        $paper = $this->createPaper($author, 'Assigned paper');
        $paper->update([
            'file_path' => 'papers/assigned.pdf',
            'file_disk' => 'local',
        ]);

        $assignedReview = Review::create([
            'paper_id' => $paper->id,
            'reviewer_id' => $reviewer->id,
        ]);
        $otherReview = Review::create([
            'paper_id' => $paper->id,
            'reviewer_id' => $otherReviewer->id,
        ]);

        $response = $this->actingAs($reviewer)
            ->get(route('reviewer.reviews.paper', $assignedReview));

        $response->assertOk()
            ->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith(
            'inline;',
            (string) $response->headers->get('content-disposition'),
        );

        $this->get(route('reviewer.reviews.paper', $assignedReview).'?download=1')
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf')
            ->assertHeader('content-disposition', 'attachment; filename=assigned.pdf');

        $this->get(route('reviewer.reviews.paper', $otherReview))
            ->assertNotFound();
    }

    public function test_non_reviewers_cannot_access_the_reviewer_panel(): void
    {
        $author = User::factory()->create([
            'role' => 'author',
        ]);

        $this->actingAs($author)
            ->get('/reviewer/dashboard')
            ->assertForbidden();
    }

    public function test_admin_can_create_assignments_but_reviewers_cannot(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $reviewer = User::factory()->create([
            'role' => 'reviewer',
        ]);

        $this->actingAs($admin)
            ->get('/admin/reviews/create')
            ->assertOk();

        $this->actingAs($reviewer)
            ->get('/reviewer/dashboard/reviews/create')
            ->assertForbidden();
    }

    private function createPaper(User $author, string $title): Paper
    {
        return Paper::create([
            'author_id' => $author->id,
            'title' => $title,
            'abstract' => 'Paper abstract',
            'keywords' => 'review, testing',
            'track' => 'AI',
            'submission_option' => 'full_submission',
            'file_path' => 'papers/paper.pdf',
            'status' => 'under_review',
            'submitted_at' => now(),
        ]);
    }
}
