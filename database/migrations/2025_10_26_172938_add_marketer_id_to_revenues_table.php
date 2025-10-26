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
        Schema::table('revenues', function (Blueprint $table) {
            $table->foreignId('marketer_id')->nullable()->after('counselor_id')->constrained('marketers')->onDelete('set null');
            $table->index('marketer_id', 'idx_marketer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->dropForeign(['marketer_id']);
            $table->dropIndex('idx_marketer_id');
            $table->dropColumn('marketer_id');
        });
    }
};
