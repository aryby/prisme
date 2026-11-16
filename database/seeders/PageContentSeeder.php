<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $contents = [];

        foreach (config('page-content', []) as $key => $field) {
            $contents[] = [
                'key' => $key,
                'label' => $field['label'],
                'content' => $field['default'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($contents, 100) as $chunk) {
            DB::table('page_contents')->insertOrIgnore($chunk);
        }

        Cache::forget('page-content');
    }
}
