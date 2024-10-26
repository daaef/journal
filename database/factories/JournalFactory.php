<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journal>
 */
class JournalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'cover_image' => 'https://via.placeholder.com/150',
            'is_active' => true,
            'uuid' => $this->faker->uuid,
            'journal_format' => 'pdf',
            'journal_language' => 'en',
            'journal_url' => 'https://example.com/journal.pdf',
            'approval_status' => 'pending',
            'meta_title' => $this->faker->sentence,
            'meta_keywords' => json_encode($this->faker->words),
            'meta_description' => $this->faker->paragraph,
            'abstract' => $this->faker->paragraph,
            'institution' => $this->faker->company,
            'license' => ['CC BY 4.0', 'CC BY 4.0'],
            'country' => 'Nigeria',
            'approval_level' => 0,
            'user_id' => 4,
            'category_id' => $this->faker->randomElement(range(1, 10)),
            // 'sub_category_id' => 1,
            // 'sub_sub_category_id' => 1,
            'created_by' => json_encode(['id' => 4, 'name' => 'Admin']),
            'updated_by' => json_encode(['id' => 4, 'name' => 'Admin']),
            'approved_by' => json_encode(['id' => 4, 'name' => 'Admin']),
            'approval_comments' => json_encode(['comments' => 'This is a test comment']),
        ];
    }
}
