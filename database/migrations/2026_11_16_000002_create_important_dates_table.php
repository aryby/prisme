<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('important_dates', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable()->unique();
            $table->string('title');
            $table->string('date');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        foreach (config('important-dates', []) as $index => $importantDate) {
            $dateKey = $importantDate['content_key'];
            $date = DB::table('page_contents')->where('key', $dateKey)->value('content')
                ?? config("page-content.{$dateKey}.default", '');

            DB::table('important_dates')->insert([
                'key' => $importantDate['key'],
                'title' => $importantDate['title'],
                'date' => $date,
                'sort_order' => $index + 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('page_contents')->updateOrInsert(
            ['key' => 'submission.enabled'],
            [
                'label' => 'Submission — accept paper submissions',
                'content' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('important_dates');
        DB::table('page_contents')->where('key', 'submission.enabled')->delete();
    }
};
