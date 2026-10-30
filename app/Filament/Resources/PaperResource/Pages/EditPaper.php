<?php

namespace App\Filament\Resources\PaperResource\Pages;

use App\Filament\Resources\PaperResource;
use App\Mail\PaperCertificate;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EditPaper extends EditRecord
{
    protected static string $resource = PaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('sendCertificate')
                ->label('Send certificate')
                ->icon('heroicon-o-envelope')
                ->color('success')
                ->schema([
                    Forms\Components\TextInput::make('email_subject')
                        ->label('Email subject')
                        ->default('Your PRISME 2026 certificate')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('email_message')
                        ->label('Email message')
                        ->default("Please find your PRISME 2026 certificate attached.\n\nYou can also download it from your author dashboard.\n\nBest regards,\nSiprisme Conference Team")
                        ->rows(8)
                        ->required()
                        ->maxLength(10000)
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('certificate')
                        ->label('Certificate PDF')
                        ->disk('local')
                        ->directory('certificates')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(10240)
                        ->required()
                        ->helperText('PDF only, maximum 10 MB. The certificate will be emailed to the paper author and made available in their dashboard.'),
                ])
                ->action(function (array $data): void {
                    $certificatePath = $data['certificate'];

                    if (! Storage::disk('local')->exists($certificatePath)) {
                        throw ValidationException::withMessages([
                            'certificate' => 'The uploaded certificate could not be found. Please upload the PDF again.',
                        ]);
                    }

                    $this->record->update([
                        'certificate_path' => $certificatePath,
                    ]);

                    Mail::to($this->record->author->email)
                        ->send(new PaperCertificate(
                            $this->record->refresh(),
                            $data['email_subject'],
                            $data['email_message'],
                        ));

                    $this->record->update([
                        'certificate_sent_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Certificate emailed to '.$this->record->author->email)
                        ->success()
                        ->send();
                })
                ->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
            Action::make('viewPdf')
                ->label('View PDF')
                ->icon('heroicon-o-document')
                ->url(fn (): string => auth()->user()?->isAdmin()
                    ? route('admin.papers.pdf', $this->record)
                    : route('author.papers.pdf', $this->record))
                ->openUrlInNewTab()
                ->visible(fn (): bool => filled($this->record->file_path)
                    && (auth()->user()?->isAdmin()
                        || (auth()->user()?->isAuthor() && $this->record->author_id === auth()->id()))),
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn (): string => (auth()->user()?->isAdmin()
                    ? route('admin.papers.pdf', $this->record)
                    : route('author.papers.pdf', $this->record)).'?download=1')
                ->visible(fn (): bool => filled($this->record->file_path)
                    && (auth()->user()?->isAdmin()
                        || (auth()->user()?->isAuthor() && $this->record->author_id === auth()->id()))),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (filled($data['paper_upload'] ?? null)) {
            $data['file_path'] = $data['paper_upload'];
            $data['file_disk'] = 'local';
        }

        unset($data['paper_upload']);

        return $data;
    }
}
