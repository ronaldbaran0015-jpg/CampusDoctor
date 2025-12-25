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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appoid');
            $table->integer('pid');
            $table->integer('apponum');
            $table->integer('scheduleid');
            $table->date('appodate');
            $table->time('start_time');   // store start of appointment
            $table->time('end_time');     // store end of appointment
            $table->enum('status', ['pending', 'finished', 'cancelled', 'missed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
