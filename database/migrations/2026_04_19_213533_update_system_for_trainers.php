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
      Schema::table('users', function (Blueprint $table) {
    $table->string('specialization')->nullable(); // For trainers: Strength, Yoga, etc.
    $table->string('working_hours')->nullable(); // For trainers: 9AM - 5PM
});

Schema::table('training_sessions', function (Blueprint $table) {
    $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('set null');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
