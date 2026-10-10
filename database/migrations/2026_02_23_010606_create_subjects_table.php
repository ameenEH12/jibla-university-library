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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المادة
            $table->string('department'); // القسم
            $table->string('level'); // المستوى
            $table->string('term'); // الترم (1، 2، أو عام للامتياز)
            
            // الحقل الأهم الذي عدلته في الكود
            $table->string('type')->default('theoretical'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
