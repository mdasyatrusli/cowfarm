<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->foreignId('breed_id')
                ->nullable()
                ->after('farm_id')
                ->constrained('breeds')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cows', function (Blueprint $table) {
            $table->dropForeign(['breed_id']);
            $table->dropColumn('breed_id');
        });
    }
};
