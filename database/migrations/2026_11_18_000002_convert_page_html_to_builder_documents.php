<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $records = DB::table('page_contents')
            ->whereNull('builder_content')
            ->get(['id', 'content']);

        foreach ($records as $record) {
            $html = trim((string) $record->content);

            if ($html === '') {
                continue;
            }

            $decoded = json_decode($html, true);

            if (is_array($decoded) && (array_is_list($decoded) || array_key_exists('en', $decoded))) {
                continue;
            }

            DB::table('page_contents')
                ->where('id', $record->id)
                ->update([
                    'builder_content' => json_encode([
                        'en' => [[
                            'type' => 'rich_text',
                            'data' => ['body' => $html],
                        ]],
                    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                ]);
        }
    }

    public function down(): void
    {
        // Builder content is additive and must not delete user-authored edits.
    }
};
