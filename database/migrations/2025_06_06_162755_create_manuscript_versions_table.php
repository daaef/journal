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
        Schema::create('manuscript_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()->cascadeOnDelete();
            $table->string('version_number'); // e.g., 1.0, 1.1, 1.2
            $table->string('title');
            $table->text('abstract');
            $table->longText('content');
            $table->text('changes_summary')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('parent_version_id')->nullable()->constrained('manuscript_versions');
            $table->json('change_requests')->nullable(); // Specific changes requested
            $table->enum('status', ['draft', 'submitted', 'under_review', 'approved', 'rejected'])->default('submitted');
            $table->timestamps();

            $table->index(['journal_id', 'version_number']);
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manuscript_versions');
    }
};
