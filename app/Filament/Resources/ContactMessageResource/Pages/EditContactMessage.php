<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use App\Mail\ContactMessageResponse as ContactMessageResponseMail;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function afterSave(): void
    {
        if (blank($this->record->response)
            || $this->record->response === $this->record->sent_response) {
            return;
        }

        Mail::to($this->record->email)->send(new ContactMessageResponseMail($this->record));

        $this->record->forceFill([
            'sent_response' => $this->record->response,
            'responded_at' => now(),
        ])->save();
    }
}
