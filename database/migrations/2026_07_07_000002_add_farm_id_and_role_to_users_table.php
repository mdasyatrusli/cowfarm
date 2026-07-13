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
            $table->foreignId('farm_id')->nullable()->after('id')->constrained('farms')->nullOnDelete();
            $table->string('role')->default('user')->after('remember_token');

            $table->index('farm_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role']);
            $table->dropForeign(['farm_id']);
            $table->dropIndex(['farm_id']);
            $table->dropColumn('farm_id');
        });
    }
};
