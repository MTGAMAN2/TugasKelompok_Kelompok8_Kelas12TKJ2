<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name');
            $table->decimal('target_amount', 16, 2);
            $table->decimal('saved_amount', 16, 2)->default(0);
            $table->date('target_date')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('goals'); }
};
