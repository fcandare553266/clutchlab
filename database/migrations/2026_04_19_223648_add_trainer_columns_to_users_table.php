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
        // Only add these if they don't exist
        if (!Schema::hasColumn('users', 'specialization')) {
            $table->string('specialization')->nullable()->after('role');
        }
        if (!Schema::hasColumn('users', 'working_hours')) {
            $table->string('working_hours')->nullable()->after('specialization');
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
