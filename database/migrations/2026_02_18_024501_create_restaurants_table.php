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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
        Schema::create('restaurant_open_times', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('day_start'); // 1 = Monday
            $table->tinyInteger('day_end');   // 7 = Sunday
            $table->time('time_start');
            $table->time('time_end');
            $table->foreignId('restaurant_id')
                ->constrained('restaurants')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_open_times');
        Schema::dropIfExists('restaurants');
    }
};