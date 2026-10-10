<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // نتحقق إذا كان العمود غير موجود فعلاً قبل إضافته
        if (!Schema::hasColumn('books', 'user_name')) {
            Schema::table('books', function (Blueprint $table) {
                $table->string('user_name')->after('user_id')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'user_name')) {
                $table->dropColumn('user_name');
            }
        });
    }
};