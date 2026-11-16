<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->longText('content');
            $table->timestamps();
        });

        $now = now();
        $contents = [];

        foreach (config('page-content', []) as $key => $field) {
            $contents[] = [
                'key' => $key,
                'label' => $field['label'],
                'content' => $field['default'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if ($contents !== []) {
            DB::table('page_contents')->insert($contents);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
