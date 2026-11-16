<?php

namespace Database\Seeders;

use App\Models\ImportantDate;
use App\Models\PageContent;
use Illuminate\Database\Seeder;

class ImportantDateSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('important-dates', []) as $index => $importantDate) {
            ImportantDate::query()->firstOrCreate(
                ['key' => $importantDate['key']],
                [
                    'title' => $importantDate['title'],
                    'date' => PageContent::text($importantDate['content_key']),
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ],
            );
        }
    }
}
