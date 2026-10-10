<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // اسم الملزمة
            $table->string('file_path'); // مسار الملف
            $table->string('category'); // القسم (medicine, pharmacy...)
            $table->integer('level'); // المستوى الدراسي
            $table->foreignId('user_id')->constrained(); // الدكتور الذي رفع الملف
            $table->timestamps();
        });
    }
}
