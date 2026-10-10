<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // اسم الملزمة (مثلاً: تشريح 1)
            $table->string('description')->nullable(); // وصف اختياري
            $table->string('file_path'); // مسار تخزين الملف في السيرفر
            $table->string('category'); // القسم (medicine, pharmacy, etc.)
            $table->integer('level'); // المستوى الدراسي (1, 2, 3, 4, 5)
            $table->enum('type', ['pdf', 'html','doc', 'image'])->default('pdf'); // نوع الملف
            
            // ربط الملزمة بالدكتور الذي قام برفعها
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};