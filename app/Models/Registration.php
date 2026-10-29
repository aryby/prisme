<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'registration_type',
        'full_name',
        'email',
        'affiliation',
        'country',
        'phone',
        'dietary_requirements',
        'special_requests',
        'registration_fee',
        'currency',
        'payment_status',
        'payment_method',
        'transaction_id',
        'payment_notes',
        'receipt_file',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
