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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('action_type' , ['CREATE', 'READ', 'UPDATE', 'DELETE']);
            $table->json('changed_fields')->nullable(); // For UPDATE actions
            $table->string('entity_type'); // Model name (e.g., Post, Category)
            $table->unsignedBigInteger('entity_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
