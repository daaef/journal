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
        Schema::table('reviewers', function (Blueprint $table) {
            // Make fullname nullable if it exists and is required
            if (Schema::hasColumn('reviewers', 'fullname')) {
                $table->string('fullname')->nullable()->change();
            }

            // Add fullname if it doesn't exist
            if (!Schema::hasColumn('reviewers', 'fullname')) {
                $table->string('fullname')->nullable()->after('email');
            }

            // Add review completion fields
            if (!Schema::hasColumn('reviewers', 'review_submitted_at')) {
                $table->timestamp('review_submitted_at')->nullable();
            }

            if (!Schema::hasColumn('reviewers', 'review_content')) {
                $table->text('review_content')->nullable();
            }

            if (!Schema::hasColumn('reviewers', 'recommendation')) {
                $table->enum('recommendation', ['accept', 'minor_revision', 'major_revision', 'reject'])->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviewers', function (Blueprint $table) {
            $table->dropColumn(['fullname', 'review_submitted_at', 'review_content', 'recommendation']);
        });
    }
};
