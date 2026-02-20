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
        Schema::table('restaurant_open_times', function (Blueprint $table) {
            $table->index(['restaurant_id', 'day_start', 'day_end'], 'restaurant_day_index');
            $table->index(['time_start', 'time_end'], 'restaurant_time_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurant_open_times', function (Blueprint $table) {
            $table->dropIndex('restaurant_day_index');
            $table->dropIndex('restaurant_time_index');
        });
    }
};