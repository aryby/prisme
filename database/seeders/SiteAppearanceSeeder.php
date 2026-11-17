<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteAppearanceSeeder extends Seeder
{
    public function run(): void
    {
        $field = config('page-content')['site.logo'];

        DB::table('page_contents')->insertOrIgnore([
            'key' => 'site.logo',
            'label' => $field['label'],
            'content' => $field['default'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Cache::forget('page-content');
    }
}
