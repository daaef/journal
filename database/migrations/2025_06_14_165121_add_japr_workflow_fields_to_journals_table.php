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
            // JAPR Workflow fields
            $table->json('managing_editor_notice')->nullable()->after('approved_by');
            $table->timestamp('managing_editor_notice_sent_at')->nullable()->after('managing_editor_notice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn(['managing_editor_notice', 'managing_editor_notice_sent_at']);
        });
    }
};
