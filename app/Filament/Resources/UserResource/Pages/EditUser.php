<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\AdminUserMessage;
use App\Models\UserEmailMessage;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sendEmail')
                ->label('Send email')
                ->icon('heroicon-o-envelope')
                ->color('info')
                ->schema([
                    Forms\Components\TextInput::make('subject')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('message')
                        ->required()
                        ->rows(8)
                        ->maxLength(10000),
                ])
                ->action(function (array $data): void {
                    $recipientEmail = $this->record->email;

                    Mail::to($recipientEmail)->send(
                        new AdminUserMessage($this->record, $data['subject'], $data['message']),
                    );

                    UserEmailMessage::create([
                        'user_id' => $this->record->id,
                        'sent_by' => auth()->id(),
                        'recipient_email' => $recipientEmail,
                        'subject' => $data['subject'],
                        'body' => $data['message'],
                        'sent_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Email sent to '.$this->record->email)
                        ->success()
                        ->send();
                }),
            DeleteAction::make(),
        ];
    }
}
