<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paper extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'title',
        'abstract',
        'keywords',
        'track',
        'submission_option',
        'affiliation',
        'country',
        'phone',
        'file_path',
        'file_disk',
        'status',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
