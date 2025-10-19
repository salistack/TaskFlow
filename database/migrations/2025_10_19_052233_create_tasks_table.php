<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This creates the 'tasks' table that stores all task details.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // primary key

            $table->string('name'); // task name
            $table->text('description')->nullable(); // optional description

            // Foreign key: each task belongs to one category
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            // If a category is deleted, its related tasks will be deleted too

            // Foreign key: task is assigned to one user
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            // If user is deleted, their tasks will also be deleted

            // Automatically set assignment date to now when created
            $table->timestamp('assignment_date')->useCurrent();

            // Deadline for task completion
            $table->date('deadline');

            // Task status options
            $table->enum('status', ['pending','in_progress','completed'])->default('pending');

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
