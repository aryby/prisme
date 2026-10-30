<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->string('certificate_path')->nullable()->after('file_disk');
            $table->timestamp('certificate_sent_at')->nullable()->after('certificate_path');
        });
    }

    public function down(): void
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->dropColumn(['certificate_path', 'certificate_sent_at']);
        });
    }
};
