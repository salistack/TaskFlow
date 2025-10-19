<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This adds a 'role' column to the existing 'users' table.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'intern'])
                  ->default('intern')
                  ->after('email');
            // Adds a role column after the email field, defaults to 'intern'
        });
    }

    /**
     * Reverse the migrations.
     *
     * Removes the 'role' column if rollback is done.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
