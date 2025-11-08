<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kolom polimorfik (commentable_id dan commentable_type)
            $table->morphs('commentable'); 
            
            // Isi dari komentar
            $table->text('body');
            
            // Untuk balasan (replies), merujuk ke 'id' di tabel 'comments' ini sendiri.
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};