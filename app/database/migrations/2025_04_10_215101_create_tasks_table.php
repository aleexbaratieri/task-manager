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
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('building_id')->foreign('buildings')->references('id');
            $table->string('author_id')->foreign('users')->references('id');
            $table->string('owner_id')->foreign('users')->references('id');
            $table->enum('status', ['OPEN', 'IN_PROGRESS', 'COMPLETED', 'REJECTED']);
            $table->timestamps();
            $table->softDeletes();
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
