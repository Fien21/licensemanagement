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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('vendo_box_no')->nullable();
            $table->string('vendo_machine')->nullable();
            $table->string('license')->nullable();
            $table->string('device_id')->nullable();
            $table->string('description')->nullable();
            $table->date('date')->nullable();
            $table->string('technician')->nullable();
            $table->string('email')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
