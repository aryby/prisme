<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('registration_type')->default('academic');
            $table->string('full_name');
            $table->string('email');
            $table->string('affiliation')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->text('dietary_requirements')->nullable();
            $table->text('special_requests')->nullable();
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->string('currency')->default('USD');
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('payment_notes')->nullable();
            $table->string('receipt_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
