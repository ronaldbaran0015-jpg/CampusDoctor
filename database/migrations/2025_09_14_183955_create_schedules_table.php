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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('scheduleid');
            $table->unsignedBigInteger('docid');
            $table->string('title'); // e.g. Consultation
            $table->date('scheduledate'); // e.g. 2025-09-28
            $table->time('start_time'); // e.g. 08:00
            $table->time('end_time');   // e.g. 11:00
            $table->integer('nop'); // max clients
            $table->timestamps();

            $table->foreign('docid')->references('docid')->on('doctors')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
