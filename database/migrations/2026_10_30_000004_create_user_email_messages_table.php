<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_email_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('recipient_email');
            $table->string('subject');
            $table->longText('body');
            $table->timestamp('sent_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_email_messages');
    }
};
