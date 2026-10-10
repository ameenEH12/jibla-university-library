<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الملف
            $table->string('file_path'); // مسار الملف في السيرفر
            $table->string('file_type'); // نوع الملف (محاضرة، عملي، الخ)
            
            // ربط الملف بالمادة الدراسية
            $table->foreignId('subject_id')->constrained('materials')->onDelete('cascade');
            
            // من الذي رفعه (ID المستخدم)
            $table->foreignId('user_id')->constrained(); 
            
            // التعديل الجديد: حفظ اسم الدكتور نصياً للبحث السريع والعرض
            $table->string('user_name')->after('user_id')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};