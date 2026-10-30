<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->cascadeOnDelete();
            $table->foreignId('commenter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->longText('body');
            $table->timestamps();
        });

        DB::table('reviews')
            ->whereNotNull('comments')
            ->where('comments', '<>', '')
            ->orderBy('id')
            ->chunkById(100, function ($reviews): void {
                $now = now();

                foreach ($reviews as $review) {
                    DB::table('review_comments')->insert([
                        'review_id' => $review->id,
                        'commenter_id' => $review->reviewer_id,
                        'body' => $review->comments,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_comments');
    }
};
