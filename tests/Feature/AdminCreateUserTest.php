<?php

namespace Tests\Feature;

use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Mail\AdminUserMessage;
use App\Mail\UserAccountCreated;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class AdminCreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_creation_generates_password_and_emails_login_details(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        Livewire::actingAs($admin)
            ->test(CreateUser::class)
            ->fillForm([
                'name' => 'New Reviewer',
                'email' => 'reviewer@example.com',
                'role' => 'reviewer',
                'status' => 'active',
                'is_active' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $user = User::where('email', 'reviewer@example.com')->firstOrFail();

        $this->assertNotEmpty($user->password);
        $this->assertNotSame('password', $user->password);

        Mail::assertSent(UserAccountCreated::class, function (UserAccountCreated $mail) use ($user): bool {
            $content = $mail->render();

            return $mail->user->is($user)
                && strlen($mail->password) === 16
                && $mail->hasTo($user->email)
                && str_contains($content, $user->email)
                && str_contains($content, $mail->password)
                && str_contains($content, route('login'));
        });
    }

    public function test_admin_can_send_a_custom_email_from_the_user_edit_page(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create([
            'name' => 'Email Recipient',
            'email' => 'recipient@example.com',
            'role' => 'author',
        ]);

        Livewire::actingAs($admin)
            ->test(EditUser::class, ['record' => $user->getRouteKey()])
            ->callAction('sendEmail', [
                'subject' => 'Submission update',
                'message' => "Your submission has been received.\nThank you.",
            ])
            ->assertHasNoActionErrors();

        Mail::assertSent(AdminUserMessage::class, function (AdminUserMessage $mail) use ($user): bool {
            $content = $mail->render();

            return $mail->user->is($user)
                && $mail->hasTo($user->email)
                && $mail->messageSubject === 'Submission update'
                && str_contains($content, 'Your submission has been received.')
                && str_contains($content, 'Thank you.');
        });

        $this->assertDatabaseHas('user_email_messages', [
            'user_id' => $user->id,
            'sent_by' => $admin->id,
            'recipient_email' => $user->email,
            'subject' => 'Submission update',
            'body' => "Your submission has been received.\nThank you.",
        ]);

        Livewire::actingAs($admin)
            ->test(EditUser::class, ['record' => $user->getRouteKey()])
            ->callAction('sendEmail', [
                'subject' => 'A second update',
                'message' => 'Your paper is now under review.',
            ])
            ->assertHasNoActionErrors();

        $this->assertDatabaseCount('user_email_messages', 2);

        $this->actingAs($admin)
            ->get(route('filament.admin.resources.users.edit', ['record' => $user]))
            ->assertOk()
            ->assertSee('Sent email history')
            ->assertSee('Submission update')
            ->assertSee('Your submission has been received.')
            ->assertSee('A second update')
            ->assertSee('Your paper is now under review.');

        Mail::assertSent(AdminUserMessage::class, 2);
    }

    public function test_admin_can_filter_users_by_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $author = User::factory()->create(['role' => 'author']);
        $reviewer = User::factory()->create(['role' => 'reviewer']);

        Livewire::actingAs($admin)
            ->test(ListUsers::class)
            ->filterTable('role', 'author')
            ->assertCanSeeTableRecords([$author])
            ->assertCanNotSeeTableRecords([$reviewer]);
    }
}
