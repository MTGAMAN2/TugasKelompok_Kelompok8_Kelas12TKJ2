<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw statement to avoid requiring doctrine/dbal for change()
        DB::statement("ALTER TABLE `transactions` MODIFY `amount` DECIMAL(16,2) NOT NULL DEFAULT 0");
    }

    public function down(): void
    {
        // Revert to NOT NULL without default (original state)
        DB::statement("ALTER TABLE `transactions` MODIFY `amount` DECIMAL(16,2) NOT NULL");
    }
};
