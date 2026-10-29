<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->longText('abstract');
            $table->string('keywords');
            $table->string('track');
            $table->string('submission_option')->nullable();
            $table->string('affiliation')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->default('under_review');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('papers');
    }
};
