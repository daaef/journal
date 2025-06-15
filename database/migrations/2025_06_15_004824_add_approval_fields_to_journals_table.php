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
            // Only add columns that don't exist
            if (!Schema::hasColumn('journals', 'approved_at')) {
                $table->timestamp('approved_at')->nullable();
            }
            if (!Schema::hasColumn('journals', 'managing_editor_notice')) {
                $table->json('managing_editor_notice')->nullable();
            }
            if (!Schema::hasColumn('journals', 'managing_editor_notice_sent_at')) {
                $table->timestamp('managing_editor_notice_sent_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('journals', 'approved_at')) {
                $columns[] = 'approved_at';
            }
            if (Schema::hasColumn('journals', 'managing_editor_notice')) {
                $columns[] = 'managing_editor_notice';
            }
            if (Schema::hasColumn('journals', 'managing_editor_notice_sent_at')) {
                $columns[] = 'managing_editor_notice_sent_at';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
