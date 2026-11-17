<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteAppearanceSeeder extends Seeder
{
    public function run(): void
    {
        $fields = config('page-content');
        $now = now();
        $contents = [];

        foreach (['site.logo', 'site.header-title', 'site.header-details'] as $key) {
            $contents[] = [
                'key' => $key,
                'label' => $fields[$key]['label'],
                'content' => $fields[$key]['default'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('page_contents')->insertOrIgnore($contents);

        Cache::forget('page-content');
    }
}
