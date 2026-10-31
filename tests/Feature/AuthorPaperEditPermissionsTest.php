<?php

namespace Tests\Feature;

use App\Filament\Resources\PaperResource\Pages\EditPaper;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AuthorPaperEditPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_edit_only_title_affiliation_country_and_phone(): void
    {
        $author = User::factory()->create([
            'role' => 'author',
        ]);
        $paper = Paper::create([
            'author_id' => $author->id,
            'title' => 'Original title',
            'abstract' => 'Original abstract',
            'keywords' => 'original, keywords',
            'track' => 'AI',
            'submission_option' => 'full_submission',
            'affiliation' => 'Original university',
            'country' => 'FR',
            'phone' => '123456',
            'file_path' => 'papers/original.pdf',
            'file_disk' => 'local',
            'status' => 'under_review',
            'submitted_at' => now(),
        ]);

        Livewire::actingAs($author)
            ->test(EditPaper::class, ['record' => $paper->getRouteKey()])
            ->assertFormFieldIsEnabled('title')
            ->assertFormFieldIsEnabled('affiliation')
            ->assertFormFieldIsEnabled('country')
            ->assertFormFieldIsEnabled('phone')
            ->assertFormFieldIsDisabled('author_id')
            ->assertFormFieldIsDisabled('track')
            ->assertFormFieldIsDisabled('status')
            ->assertFormFieldIsDisabled('submission_option')
            ->assertFormFieldIsDisabled('paper_upload')
            ->assertFormFieldIsDisabled('submitted_at')
            ->assertFormFieldIsDisabled('abstract')
            ->assertFormFieldIsDisabled('keywords')
            ->assertActionHidden('delete')
            ->fillForm([
                'title' => 'Updated title',
                'affiliation' => 'Updated university',
                'country' => 'US',
                'phone' => '654321',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $paper->refresh();

        $this->assertSame('Updated title', $paper->title);
        $this->assertSame('Updated university', $paper->affiliation);
        $this->assertSame('US', $paper->country);
        $this->assertSame('654321', $paper->phone);
    }

    public function test_author_save_discards_changes_to_other_paper_fields(): void
    {
        $author = User::factory()->create([
            'role' => 'author',
        ]);
        $this->actingAs($author);

        $method = new \ReflectionMethod(EditPaper::class, 'mutateFormDataBeforeSave');
        $data = $method->invoke(new EditPaper(), [
            'title' => 'Updated title',
            'affiliation' => 'Updated university',
            'country' => 'US',
            'phone' => '654321',
            'status' => 'accepted',
            'track' => 'Tampered track',
            'paper_upload' => 'papers/tampered.pdf',
        ]);

        $this->assertSame([
            'title' => 'Updated title',
            'affiliation' => 'Updated university',
            'country' => 'US',
            'phone' => '654321',
        ], $data);
    }
}
