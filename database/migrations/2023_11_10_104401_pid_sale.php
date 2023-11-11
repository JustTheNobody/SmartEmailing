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
        Schema::create('pid_sale', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->foreignId('pid_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('pid_service_id')->constrained()->onDelete('cascade');
            $table->integer('pid_pay_method_id',11)->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->double('lat', 10, 6);
            $table->double('lon', 10, 6);
            $table->integer('services');
            $table->string('link')->nullable();
            $table->string('remarks')->nullable();
            $table->index(['id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pid_sale');
    }
};
