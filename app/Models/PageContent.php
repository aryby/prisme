<?php

namespace App\Models;

use Ferga\FilamentBuilder\Concerns\HasBuilderContent;
use Ferga\FilamentBuilder\FergaBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageContent extends Model
{
    use HasBuilderContent;

    protected $fillable = [
        'key',
        'label',
        'content',
        'builder_content',
    ];

    protected function casts(): array
    {
        return [
            'builder_content' => 'array',
        ];
    }

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

    public function syncContentFromBuilder(): void
    {
        $documents = $this->builderDocuments('builder_content');

        $this->forceFill(['content' => static::contentFromBuilder($documents)])->save();
    }

    public static function contentFromBuilder(array $documents): string
    {
        $html = app(FergaBuilder::class)
            ->renderer()
            ->renderDocuments($documents, config('ferga-builder.default_locale', 'en'))
            ->toHtml();

        return trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('page-content'));
        static::deleted(fn () => Cache::forget('page-content'));
    }
}
