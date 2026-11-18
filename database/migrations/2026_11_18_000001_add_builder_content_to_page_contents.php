<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->json('builder_content')->nullable()->after('content');
        });

        $records = DB::table('page_contents')
            ->whereNull('builder_content')
            ->get(['id', 'key', 'content']);

        foreach ($records as $record) {
            $html = trim((string) $record->content);

            if ($html === '' || str_starts_with($html, '[') || str_starts_with($html, '{')) {
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
        Schema::table('page_contents', function (Blueprint $table) {
            $table->dropColumn('builder_content');
        });
    }
};
