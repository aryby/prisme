<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function papers(): HasMany
    {
        return $this->hasMany(Paper::class, 'author_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(UserEmailMessage::class)->latest('sent_at');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->isAdmin(),
            'author' => $this->isAuthor(),
            'reviewer' => $this->isReviewer(),
            default => false,
        };
    }

    public function hasVerifiedEmail(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => now(),
        ])->save();
    }

    public function sendEmailVerificationNotification(): void
    {
        Mail::to($this->email)->send(new \App\Mail\AccountValidation($this));
    }

    public function getEmailForVerification(): string
    {
        return $this->email;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAuthor(): bool
    {
        return $this->role === 'author';
    }

    public function isReviewer(): bool
    {
        return $this->role === 'reviewer';
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
}
