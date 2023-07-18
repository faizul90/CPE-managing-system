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
        Schema::table('workorderunifis', function (Blueprint $table) {
            $table->timestamp('planned_start')->nullable();
            $table->text('account_name')->nullable();
            $table->text('platform')->nullable();
            $table->text('location_dp')->nullable();
            $table->text('type')->nullable();
            $table->text('status')->nullable();
            $table->text('assignment_type')->nullable();
            $table->text('order_status')->nullable();
            $table->timestamp('created')->nullable();
            $table->text('product_name')->nullable();
            $table->text('segment_sub_group')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workorderunifis', function (Blueprint $table) {
            $table->dropColumn('planned_start');
            $table->dropColumn('account_name');
            $table->dropColumn('platform');
            $table->dropColumn('location_dp');
            $table->dropColumn('type');
            $table->dropColumn('status');
            $table->dropColumn('assignment_type');
            $table->dropColumn('order_status');
            $table->dropColumn('created');
            $table->dropColumn('product_name');
            $table->dropColumn('segment_sub_group');
        });
    }
};
