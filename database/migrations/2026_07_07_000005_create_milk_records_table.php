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
        Schema::create('milk_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained('cows')->cascadeOnDelete();
            $table->foreignId('farm_id')->constrained('farms')->cascadeOnDelete();
            $table->date('record_date');
            $table->string('session');
            $table->decimal('volume_liters', 8, 2);
            $table->timestamps();

            $table->index('farm_id');
            $table->index('cow_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_records');
    }
};
