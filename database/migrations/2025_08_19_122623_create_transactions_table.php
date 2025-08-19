<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('wallet_id')->constrained();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('vendor_id')->nullable()->constrained();
            $table->enum('type', ['income','expense','transfer']);
            $table->decimal('amount', 16, 2);
            $table->date('transacted_at');
            $table->string('note')->nullable();
            $table->string('attachment_path')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('transactions'); }
};
