<?php

use Ferga\FilamentBuilder\Blocks\ButtonBlock;
use Ferga\FilamentBuilder\Blocks\CallToActionBlock;
use Ferga\FilamentBuilder\Blocks\CardsBlock;
use Ferga\FilamentBuilder\Blocks\DividerBlock;
use Ferga\FilamentBuilder\Blocks\FaqBlock;
use Ferga\FilamentBuilder\Blocks\FileDownloadBlock;
use Ferga\FilamentBuilder\Blocks\GalleryBlock;
use Ferga\FilamentBuilder\Blocks\HeadingBlock;
use Ferga\FilamentBuilder\Blocks\HeroBlock;
use Ferga\FilamentBuilder\Blocks\HighlightsBlock;
use Ferga\FilamentBuilder\Blocks\ImageBlock;
use Ferga\FilamentBuilder\Blocks\ImageTextBlock;
use Ferga\FilamentBuilder\Blocks\LogosBlock;
use Ferga\FilamentBuilder\Blocks\QuoteBlock;
use Ferga\FilamentBuilder\Blocks\RichTextBlock;
use Ferga\FilamentBuilder\Blocks\SectionBlock;
use Ferga\FilamentBuilder\Blocks\SpacerBlock;
use Ferga\FilamentBuilder\Blocks\StatsBlock;
use Ferga\FilamentBuilder\Blocks\TestimonialsBlock;
use Ferga\FilamentBuilder\Blocks\VideoBlock;

return [
    'locales' => [
        'en' => 'English',
        'ar' => 'العربية',
        'fr' => 'Français',
        'ku' => 'کوردی',
    ],
    'default_locale' => 'en',
    'fallback' => true,
    'rtl_locales' => ['ar', 'ku', 'ckb', 'fa', 'he', 'ur', 'ps', 'sd', 'yi', 'dv'],
    'disk' => 'public',
    'upload_directory' => 'ferga-builder',
    'blocks' => [
        SectionBlock::class,
        HeroBlock::class,
        HeadingBlock::class,
        RichTextBlock::class,
        ImageBlock::class,
        ImageTextBlock::class,
        GalleryBlock::class,
        VideoBlock::class,
        QuoteBlock::class,
        ButtonBlock::class,
        CallToActionBlock::class,
        HighlightsBlock::class,
        CardsBlock::class,
        StatsBlock::class,
        TestimonialsBlock::class,
        FaqBlock::class,
        LogosBlock::class,
        FileDownloadBlock::class,
        DividerBlock::class,
        SpacerBlock::class,
    ],
    'core_templates' => true,
    'history_limit' => 50,
];
