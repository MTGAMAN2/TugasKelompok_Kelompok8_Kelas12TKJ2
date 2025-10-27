<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // If there's an 'amount' column, rename it to 'limit_amount' and preserve values
        if (Schema::hasColumn('budgets', 'amount')) {
            DB::statement("ALTER TABLE `budgets` CHANGE `amount` `limit_amount` DECIMAL(15,2) NOT NULL DEFAULT 0");
        }

        // Make start_date and end_date nullable
        if (Schema::hasColumn('budgets', 'start_date') || Schema::hasColumn('budgets', 'end_date')) {
            DB::statement("ALTER TABLE `budgets` MODIFY `start_date` DATE NULL, MODIFY `end_date` DATE NULL");
        }

        // Add name, alert_threshold and notes if missing
        if (!Schema::hasColumn('budgets', 'name')) {
            DB::statement("ALTER TABLE `budgets` ADD COLUMN `name` VARCHAR(255) NULL AFTER `category_id`");
        }

        if (!Schema::hasColumn('budgets', 'alert_threshold')) {
            DB::statement("ALTER TABLE `budgets` ADD COLUMN `alert_threshold` TINYINT UNSIGNED NOT NULL DEFAULT 80 AFTER `end_date`");
        }

        if (!Schema::hasColumn('budgets', 'notes')) {
            DB::statement("ALTER TABLE `budgets` ADD COLUMN `notes` TEXT NULL AFTER `alert_threshold`");
        }
    }

    public function down(): void
    {
        // best-effort revert: remove added columns if they exist
        if (Schema::hasColumn('budgets', 'notes')) {
            DB::statement("ALTER TABLE `budgets` DROP COLUMN `notes`");
        }
        if (Schema::hasColumn('budgets', 'alert_threshold')) {
            DB::statement("ALTER TABLE `budgets` DROP COLUMN `alert_threshold`");
        }
        if (Schema::hasColumn('budgets', 'name')) {
            DB::statement("ALTER TABLE `budgets` DROP COLUMN `name`");
        }
        // rename limit_amount back to amount if present
        if (Schema::hasColumn('budgets', 'limit_amount')) {
            DB::statement("ALTER TABLE `budgets` CHANGE `limit_amount` `amount` DECIMAL(16,2) NOT NULL");
        }
    }
};
