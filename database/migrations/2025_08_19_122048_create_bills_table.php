<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->decimal('amount', 16, 2);
            $table->enum('frequency', ['daily','weekly','monthly','yearly']);
            $table->date('next_due_date');
            $table->boolean('auto_pay')->default(false);
            $table->foreignId('wallet_id')->nullable()->constrained();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('bills'); }
};
