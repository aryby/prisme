<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\UserAccountCreated;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $generatedPassword = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->generatedPassword = Str::random(16);
        $data['password'] = $this->generatedPassword;

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->generatedPassword === null) {
            throw new \LogicException('A password was not generated for the new user.');
        }

        Mail::to($this->record->email)->send(
            new UserAccountCreated($this->record, $this->generatedPassword),
        );

        Notification::make()
            ->title('User created and login details emailed')
            ->success()
            ->send();
    }
}
