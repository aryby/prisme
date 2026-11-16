<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CommitteePageSeeder extends Seeder
{
    public function run(): void
    {
        $fields = config('page-content');
        $now = now();
        $contents = [];

        foreach (['committee.title', 'committee.description', 'committee.page'] as $key) {
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
