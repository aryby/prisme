<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageContent extends Model
{
    protected $fillable = [
        'key',
        'label',
        'content',
    ];

    public static function text(string $key): string
    {
        $contents = Cache::rememberForever(
            'page-content',
            fn (): array => static::query()->pluck('content', 'key')->all(),
        );

        $default = config('page-content')[$key]['default'] ?? '';

        return $contents[$key] ?? $default;
    }

    public static function submissionsEnabled(): bool
    {
        return static::text('submission.enabled') === '1';
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('page-content'));
        static::deleted(fn () => Cache::forget('page-content'));
    }
}
