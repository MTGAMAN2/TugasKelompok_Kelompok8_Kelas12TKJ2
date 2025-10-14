<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // Karena wallets sudah punya user_id, kita tidak ubah lagi
    if (!Schema::hasColumn('categories', 'user_id')) {
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    if (!Schema::hasColumn('transactions', 'user_id')) {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }
}

public function down(): void
{
    Schema::table('categories', function (Blueprint $table) {
        $table->dropConstrainedForeignId('user_id');
    });
    Schema::table('transactions', function (Blueprint $table) {
        $table->dropConstrainedForeignId('user_id');
    });
}
};
