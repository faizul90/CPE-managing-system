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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('batch');
            $table->string('material_no');
            $table->string('description');
            $table->string('serial_no')->unique();
            $table->string('equipment_status')->nullable();
            $table->string('valuation_type')->nullable();
            $table->string('reason')->nullable();
            $table->string('aging')->nullable();
            $table->string('installation_order_no')->nullable();
            $table->timestamp('installation_date')->nullable();
            $table->string('remark')->nullable();
            $table->timestamp('warranty_start')->nullable();
            $table->timestamp('warranty_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
