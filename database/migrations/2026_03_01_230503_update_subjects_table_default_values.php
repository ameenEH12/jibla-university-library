<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // تحديث الحقول لتكون قابلة للـ NULL أو تعيين قيمة افتراضية
            $table->string('term')->default('1')->change();
            $table->string('type')->default('theoretical')->change();
        });
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // العودة للحالة السابقة إذا لزم الأمر
            $table->string('term')->nullable(false)->change();
            $table->string('type')->nullable(false)->change();
        });
    }
};