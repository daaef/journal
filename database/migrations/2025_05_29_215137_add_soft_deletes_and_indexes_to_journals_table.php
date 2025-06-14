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
        Schema::table('journals', function (Blueprint $table) {
            $table->softDeletes();
            $table->index('uuid');
            $table->index('approval_status');
            $table->index('user_id');
        });

        Schema::table('reviewers', function (Blueprint $table) {
            $table->index(['journal_id', 'user_id']);
            $table->index('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex(['uuid']);
            $table->dropIndex(['approval_status']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('reviewers', function (Blueprint $table) {
            $table->dropIndex(['journal_id', 'user_id']);
            $table->dropIndex(['token']);
        });
    }
};
