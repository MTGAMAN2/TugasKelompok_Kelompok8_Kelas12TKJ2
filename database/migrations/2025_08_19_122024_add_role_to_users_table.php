<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                  ->default(3) // default role: User
                  ->after('id')
                  ->constrained('roles')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']); // hapus foreign key dulu
            $table->dropColumn('role_id');    // baru hapus kolom
        });
    }
};
