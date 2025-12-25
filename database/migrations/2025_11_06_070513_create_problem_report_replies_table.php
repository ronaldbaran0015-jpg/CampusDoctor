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
        Schema::create('problem_report_replies', function (Blueprint $table) {
            $table->id();
              $table->foreignId('problem_report_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->references('adminid')->on('admins')->onDelete('cascade');
            $table->text('reply');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problem_report_replies');
    }
};
