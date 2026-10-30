<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewComment extends Model
{
    protected $fillable = [
        'review_id',
        'commenter_id',
        'body',
    ];

    protected static function booted(): void
    {
        static::creating(function (ReviewComment $comment): void {
            if (blank($comment->commenter_id) && auth()->check()) {
                $comment->commenter_id = auth()->id();
            }
        });
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    public function commenter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commenter_id');
    }
}
