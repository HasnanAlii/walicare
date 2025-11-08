<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kolom polimorfik (likeable_id dan likeable_type)
            $table->morphs('likeable'); 
            
            $table->timestamps();

            // Kunci unik: Mencegah seorang user me-like item yang sama lebih dari sekali.
            $table->unique(['user_id', 'likeable_id', 'likeable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};