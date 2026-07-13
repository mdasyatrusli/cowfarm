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
        Schema::create('cows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms')->cascadeOnDelete();
            $table->string('tag_number');
            $table->string('name')->nullable();
            $table->string('breed');
            $table->string('gender');
            $table->date('birth_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->unique(['farm_id', 'tag_number']);
            $table->index('farm_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cows');
    }
};
