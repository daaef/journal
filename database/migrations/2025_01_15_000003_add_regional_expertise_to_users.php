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
            // Regional expertise fields
            $table->json('regional_expertise')->nullable()->comment('Countries/regions where user has expertise');
            $table->json('research_interests')->nullable()->comment('Research areas and specializations');
            $table->string('academic_degree')->nullable()->comment('Highest academic degree');
            $table->text('biography')->nullable()->comment('Academic biography');
            $table->text('publications')->nullable()->comment('Key publications');
            $table->string('specialization')->nullable()->comment('Primary research specialization');
            $table->string('institution_region')->nullable()->comment('Region of current institution');
            
            // Performance tracking
            $table->integer('review_count')->default(0)->comment('Total number of reviews completed');
            $table->decimal('average_rating', 3, 2)->nullable()->comment('Average review rating (1-5)');
            $table->timestamp('last_review_at')->nullable()->comment('Last review completion date');
            
            // Availability
            $table->boolean('available_for_review')->default(true)->comment('Currently available for review assignments');
            $table->integer('max_reviews_per_month')->default(5)->comment('Maximum reviews willing to do per month');
            $table->json('preferred_review_types')->nullable()->comment('Preferred manuscript types for review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'regional_expertise',
                'research_interests', 
                'academic_degree',
                'biography',
                'publications',
                'specialization',
                'institution_region',
                'review_count',
                'average_rating',
                'last_review_at',
                'available_for_review',
                'max_reviews_per_month',
                'preferred_review_types'
            ]);
        });
    }
}; 