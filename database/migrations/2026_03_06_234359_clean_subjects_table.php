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
        Schema::table('subjects', function (Blueprint $table) {
            // التأكد من وجود الحقول الأساسية التي يحتاجها الكنترولر
            if (!Schema::hasColumn('subjects', 'term')) $table->string('term');
            if (!Schema::hasColumn('subjects', 'level')) $table->integer('level');
            if (!Schema::hasColumn('subjects', 'department')) $table->string('department');
            
            // حذف حقل type من هنا لأننا سنفلتر الكتب وليس المواد
            if (Schema::hasColumn('subjects', 'type')) $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
