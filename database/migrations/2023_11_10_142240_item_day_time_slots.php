<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pid_day_time_slots', function (Blueprint $table) {
            $table->id();
            $table->string('pid_sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('day_id')->constrained()->onDelete('cascade');
            $table->foreignId('pid_time_slot_id')->constrained()->onDelete('cascade');
            $table->unique(['pid_sale_id', 'day_id', 'pid_time_slot_id']);
            $table->index(['pid_sale_id', 'day_id', 'pid_time_slot_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pid_day_time_slots');
    }
};
