<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $fields = config('page-content');
        $page = $fields['committee.page'];
        $organizingCommittee = DB::table('page_contents')
            ->where('key', 'committee.organizing')
            ->value('content');
        $pageExists = DB::table('page_contents')
            ->where('key', 'committee.page')
            ->exists();
        $content = $page['default'];

        if (! $pageExists && $organizingCommittee !== null) {
            $members = preg_split('/\r\n|\r|\n/', $organizingCommittee);
            $memberItems = collect($members)
                ->filter(fn (string $member): bool => trim($member) !== '')
                ->map(fn (string $member): string => '<li>'.htmlspecialchars($member, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').'</li>')
                ->implode('');

            $content = preg_replace_callback(
                '/(<h4><strong>Organizing Committee<\/strong><\/h4>\s*<ul>).*?(<\/ul>)/s',
                fn (array $matches): string => $matches[1].$memberItems.$matches[2],
                $content,
                1,
            );
        }

        if (! $pageExists) {
            DB::table('page_contents')->insert([
                'key' => 'committee.page',
                'label' => $page['label'],
                'content' => $content,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach (['committee.title', 'committee.description'] as $key) {
            $field = $fields[$key];

            DB::table('page_contents')->insertOrIgnore([
                'key' => $key,
                'label' => $field['label'],
                'content' => $field['default'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('page_contents')
            ->where('key', 'committee.organizing')
            ->delete();

        Cache::forget('page-content');
    }

    public function down(): void
    {
        $fields = config('page-content');

        foreach (['committee.page', 'committee.title', 'committee.description'] as $key) {
            DB::table('page_contents')
                ->where('key', $key)
                ->where('content', $fields[$key]['default'])
                ->delete();
        }

        Cache::forget('page-content');
    }
};
