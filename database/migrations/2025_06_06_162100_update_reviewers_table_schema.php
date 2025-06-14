<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReviewersTableSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviewers', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('reviewers', 'email')) {
                $table->string('email')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('reviewers', 'status')) {
                $table->enum('status', ['invited', 'accepted', 'declined', 'completed'])->default('invited')->after('email');
            }

            if (!Schema::hasColumn('reviewers', 'token')) {
                $table->string('token', 64)->nullable()->after('status');
            }

            if (!Schema::hasColumn('reviewers', 'invited_at')) {
                $table->timestamp('invited_at')->nullable()->after('token');
            }

            if (!Schema::hasColumn('reviewers', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable()->after('invited_at');
            }

            if (!Schema::hasColumn('reviewers', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('accepted_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviewers', function (Blueprint $table) {
            $table->dropColumn(['email', 'status', 'token', 'invited_at', 'accepted_at', 'completed_at']);
        });
    }
}
