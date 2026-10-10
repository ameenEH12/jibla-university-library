<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل الميجريشن لإضافة العمود
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // إضافة عمود الرتبة بعد الإيميل
            // الحالات: student, doctor, admin
            $table->string('role')->default('student')->after('email'); 
        });
    }

    /**
     * التراجع عن الميجريشن وحذف العمود
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // حذف العمود في حال عمل Rollback
            $table->dropColumn('role');
        });
    }
};