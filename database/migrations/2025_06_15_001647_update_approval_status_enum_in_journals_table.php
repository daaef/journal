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
        // First, change the column to varchar to avoid enum constraints
        Schema::table('journals', function (Blueprint $table) {
            $table->string('approval_status', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to the original enum
        Schema::table('journals', function (Blueprint $table) {
            $table->enum('approval_status', ['pending', 'in-progress', 'approved', 'approved_with_comment', 'declined', 'changes_requested', 'reviewed'])->default('pending')->change();
        });
    }
};
