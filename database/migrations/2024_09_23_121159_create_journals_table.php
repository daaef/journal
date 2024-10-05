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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->longText('author');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('uuid')->unique();
            $table->string('journal_format')->nullable();
            $table->string('journal_language')->nullable();
            $table->string('journal_url')->nullable();
            $table->enum('approval_status', ['pending', 'in-progress', 'approved', 'declined'])->default('pending');
            $table->string('meta_title')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('abstract')->nullable();
            $table->longText('institution')->nullable();
            $table->string('license')->nullable();
            $table->string('country')->nullable();

            //approval levels
            $table->integer('approval_level')->default(0);

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');

            $table->unsignedBigInteger('sub_sub_category_id')->nullable();
            $table->foreign('sub_sub_category_id')->references('id')->on('sub_sub_categories')->onDelete('cascade');

            $table->json('created_by')->nullable();
            $table->json('updated_by')->nullable();
            $table->json('approved_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
