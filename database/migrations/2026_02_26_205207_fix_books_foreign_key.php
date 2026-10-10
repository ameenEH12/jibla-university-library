<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // 1. حذف القيود القديمة (إن وجدت)
    try {
        $foreignKeys = DB::select(
            "SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
             WHERE TABLE_NAME = 'books' AND COLUMN_NAME = 'subject_id' 
             AND TABLE_SCHEMA = '" . DB::getDatabaseName() . "' 
             AND REFERENCED_TABLE_NAME IS NOT NULL"
        );
        foreach ($foreignKeys as $fk) {
            DB::statement("ALTER TABLE books DROP FOREIGN KEY " . $fk->CONSTRAINT_NAME);
        }
    } catch (\Exception $e) {}

    // 2. تفريغ جدول الكتب لتجنب تعارض البيانات اليتيمة
    DB::table('books')->truncate(); 

    // 3. الآن نطبق الربط بجدول subjects ونحن مطمئنين
    Schema::table('books', function (Blueprint $table) {
        $table->foreign('subject_id')
              ->references('id')
              ->on('subjects')
              ->onDelete('cascade');
    });
}

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->foreign('subject_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }
};