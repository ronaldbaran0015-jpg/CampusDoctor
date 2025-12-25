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
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staffid');
            $table->string('staffname');
            $table->string('staffemail'); 
            $table->string('staffcontact');
            $table->string('staffpassword');
            $table->string('staffrole');
            $table->string('staffimage')->nullable(); // <-- add this
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
