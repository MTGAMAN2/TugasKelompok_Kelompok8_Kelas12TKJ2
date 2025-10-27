<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            if (!Schema::hasColumn('goals', 'deadline')) {
                $table->date('deadline')->nullable();
            }
            if (!Schema::hasColumn('goals', 'priority')) {
                $table->string('priority')->default('medium');
            }
            if (!Schema::hasColumn('goals', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable();
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->dropColumn(['deadline', 'priority']);
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
