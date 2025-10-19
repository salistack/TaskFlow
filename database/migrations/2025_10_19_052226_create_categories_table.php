<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method defines how the 'categories' table will be created.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary key: auto-increment integer 'id'

            $table->string('name')->unique(); // category name (unique)

            $table->text('description')->nullable(); // description (optional)

            $table->enum('status', ['active','inactive'])->default('active');
            // 'status' field — can be either 'active' or 'inactive'; default 'active'

            $table->timestamps(); // creates 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * This drops the table if we rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
