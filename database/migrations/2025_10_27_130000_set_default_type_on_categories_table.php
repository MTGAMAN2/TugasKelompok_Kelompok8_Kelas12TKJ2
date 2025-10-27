<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // make sure the enum has a default to avoid failed inserts when 'type' is missing
        DB::statement("ALTER TABLE `categories` MODIFY `type` ENUM('income','expense') NOT NULL DEFAULT 'expense'");
    }

    public function down(): void
    {
        // revert to NOT NULL without default (best-effort)
        DB::statement("ALTER TABLE `categories` MODIFY `type` ENUM('income','expense') NOT NULL");
    }
};
