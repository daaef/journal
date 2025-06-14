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
            // Only add fields that don't exist yet
            if (!Schema::hasColumn('reviewers', 'confidential_comments')) {
                $table->longText('confidential_comments')->nullable()->after('comment');
            }
            
            if (!Schema::hasColumn('reviewers', 'criteria_ratings')) {
                $table->json('criteria_ratings')->nullable()->after('rating');
            }
            
            if (!Schema::hasColumn('reviewers', 'status')) {
                $table->string('status')->default('pending')->after('recommendation');
            }
            
            if (!Schema::hasColumn('reviewers', 'assigned_at')) {
                $table->timestamp('assigned_at')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviewers', function (Blueprint $table) {
            $table->dropColumn([
                'confidential_comments',
                'criteria_ratings', 
                'status',
                'assigned_at'
            ]);
        });
    }
};
