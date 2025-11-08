<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // jika donor terdaftar
            $table->string('donor_name')->nullable();
            $table->string('donor_email')->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('method', ['bank_transfer','ewallet','va','manual'])->default('manual');
            $table->enum('status', ['pending','confirmed','failed','refunded'])->default('pending');
            $table->string('transaction_id')->nullable(); // dari payment gateway
            $table->string('proof_path')->nullable(); // bukti transfer upload
            $table->timestamp('paid_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
