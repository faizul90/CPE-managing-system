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
        Schema::create('workorderunifis', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->string('team_id')->nullable();
            $table->timestamp('date_transferred')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('source_system')->nullable();
            $table->string('consumption_type')->nullable();
            $table->string('exchange_code')->nullable();
            $table->string('segment_group')->nullable();
            $table->string('batch')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorderunifis');
    }
};
