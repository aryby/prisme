<?php

namespace Tests\Feature;

use App\Filament\Resources\ContactMessageResource\Pages\EditContactMessage;
use App\Mail\ContactMessageResponse;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_submit_a_contact_message(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Sam Visitor',
            'email' => 'sam@example.com',
            'subject' => 'Question about the symposium',
            'message' => 'When does the event start?',
        ])
            ->assertRedirect(route('contact'))
            ->assertSessionHas('contact_status');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Sam Visitor',
            'email' => 'sam@example.com',
            'subject' => 'Question about the symposium',
            'message' => 'When does the event start?',
            'response' => null,
            'sent_response' => null,
        ]);
    }

    public function test_admin_can_save_and_email_a_response_to_the_contact(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $message = ContactMessage::create([
            'name' => 'Sam Visitor',
            'email' => 'sam@example.com',
            'subject' => 'Question about the symposium',
            'message' => 'When does the event start?',
        ]);

        $this->actingAs($admin)
            ->get('/admin/contact-messages')
            ->assertOk()
            ->assertSee($message->subject);

        Livewire::actingAs($admin)
            ->test(EditContactMessage::class, ['record' => $message->getRouteKey()])
            ->fillForm(['response' => 'The event starts at 9:00 AM.'])
            ->call('save')
            ->assertHasNoFormErrors();

        $message->refresh();
        $this->assertSame('The event starts at 9:00 AM.', $message->response);
        $this->assertSame($message->response, $message->sent_response);
        $this->assertNotNull($message->responded_at);

        Mail::assertSent(ContactMessageResponse::class, function (ContactMessageResponse $mail): bool {
            return $mail->hasTo('sam@example.com')
                && $mail->contactMessage->response === 'The event starts at 9:00 AM.'
                && str_contains($mail->render(), 'The event starts at 9:00 AM.');
        });

        Livewire::actingAs($admin)
            ->test(EditContactMessage::class, ['record' => $message->getRouteKey()])
            ->fillForm(['response' => 'The event starts at 9:00 AM.'])
            ->call('save')
            ->assertHasNoFormErrors();

        Mail::assertSent(ContactMessageResponse::class, 1);
    }

    public function test_non_admin_cannot_access_contact_messages_in_admin_panel(): void
    {
        $author = User::factory()->create(['role' => 'author']);

        $this->actingAs($author)
            ->get('/admin/contact-messages')
            ->assertForbidden();
    }
}
