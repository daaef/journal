<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Journal;
use App\Models\Category;
use App\Models\Reviewer;
use Spatie\Permission\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EditorialWorkflowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $author;
    protected $editor;
    protected $reviewer1;
    protected $reviewer2;
    protected $journal;    protected function setUp(): void
    {
        parent::setUp();
        
        // Create roles first
        $editorRole = Role::create(['name' => 'Managing Editor']);
        $reviewerRole = Role::create(['name' => 'Reviewer']);
        $authorRole = Role::create(['name' => 'Author']);
        
        // Create a test category first
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'uuid' => $this->faker->uuid(),
            'description' => 'Test category for testing',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Create test users with different roles
        $this->author = User::factory()->create([
            'fullname' => 'Test Author',
            'email' => 'author@test.com'
        ]);
        $this->author->assignRole($authorRole);

        $this->editor = User::factory()->create([
            'fullname' => 'Test Editor',
            'email' => 'editor@test.com'
        ]);
        $this->editor->assignRole($editorRole);

        $this->reviewer1 = User::factory()->create([
            'fullname' => 'Test Reviewer 1',
            'email' => 'reviewer1@test.com'
        ]);
        $this->reviewer1->assignRole($reviewerRole);

        $this->reviewer2 = User::factory()->create([
            'fullname' => 'Test Reviewer 2',
            'email' => 'reviewer2@test.com'
        ]);
        $this->reviewer2->assignRole($reviewerRole);

        // Create a test journal
        $this->journal = Journal::factory()->create([
            'user_id' => $this->author->id,
            'category_id' => $category->id,
            'title' => 'Test Manuscript for Editorial Workflow',
            'approval_status' => 'submitted'
        ]);
    }

    public function test_editor_can_access_journal_preview_page()
    {
        $response = $this->actingAs($this->editor)
                         ->get("/dashboard/editor/journals/{$this->journal->uuid}/{$this->journal->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.editor.journals.journalPreview');
        $response->assertViewHas('journal');
        $response->assertSee('Reviewer Assignment');
    }

    public function test_reviewer_assignment_requires_2_to_4_reviewers()
    {
        // Test with only 1 reviewer (should fail)
        $response = $this->actingAs($this->editor)
                         ->post("/dashboard/editor/journals/reviewers/{$this->journal->uuid}", [
                             'reviewers' => [$this->reviewer1->uuid]
                         ]);

        $response->assertRedirect();
        $response->assertSessionHas('alert-type', 'error');
        $response->assertSessionHas('message');

        // Test with 2 reviewers (should succeed)
        $response = $this->actingAs($this->editor)
                         ->post("/dashboard/editor/journals/reviewers/{$this->journal->uuid}", [
                             'reviewers' => [$this->reviewer1->uuid, $this->reviewer2->uuid]
                         ]);

        $response->assertRedirect();
        $response->assertSessionHas('alert-type', 'success');
          // Verify assignment in database
        $this->assertDatabaseHas('reviewers', [
            'journal_id' => $this->journal->id,
            'reviewer_id' => $this->reviewer1->id
        ]);
    }

    public function test_reviewer_assignment_prevents_more_than_4_reviewers()
    {
        // Create additional reviewers
        $reviewer3 = User::factory()->create(['role' => 'reviewer']);
        $reviewer4 = User::factory()->create(['role' => 'reviewer']);
        $reviewer5 = User::factory()->create(['role' => 'reviewer']);

        // Test with 5 reviewers (should fail)
        $response = $this->actingAs($this->editor)
                         ->post("/dashboard/editor/journals/reviewers/{$this->journal->uuid}", [
                             'reviewers' => [
                                 $this->reviewer1->uuid,
                                 $this->reviewer2->uuid,
                                 $reviewer3->uuid,
                                 $reviewer4->uuid,
                                 $reviewer5->uuid
                             ]
                         ]);

        $response->assertRedirect();
        $response->assertSessionHas('alert-type', 'error');
        $response->assertSessionHas('message');
    }

    public function test_reviewer_can_access_assigned_manuscript()
    {        // First assign reviewer to journal
        Reviewer::create([
            'journal_id' => $this->journal->id,
            'reviewer_id' => $this->reviewer1->id
        ]);

        $response = $this->actingAs($this->reviewer1)
                         ->get("/dashboard/reviewer/journals/{$this->journal->uuid}/{$this->journal->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.reviewer.journals.journalPreview');
    }

    public function test_reviewer_cannot_access_unassigned_manuscript()
    {
        // Don't assign reviewer to journal
        $response = $this->actingAs($this->reviewer1)
                         ->get("/dashboard/reviewer/journals/{$this->journal->uuid}/{$this->journal->slug}");

        $response->assertStatus(403);
    }

    public function test_editorial_decision_approve_functionality()
    {
        $response = $this->actingAs($this->editor)
                         ->post('/dashboard/editor/journals/approve-for-publication', [
                             'journal_uuid' => $this->journal->uuid
                         ]);

        $response->assertRedirect();
        $response->assertSessionHas('alert-type', 'success');
    }

    public function test_editorial_decision_reject_with_reason()
    {
        $response = $this->actingAs($this->editor)
                         ->post('/dashboard/editor/journals/reject-manuscript', [
                             'journal_uuid' => $this->journal->uuid,
                             'reason' => 'Manuscript does not meet journal standards'
                         ]);

        $response->assertRedirect();
        $response->assertSessionHas('alert-type', 'success');
    }

    public function test_editorial_decision_reject_requires_reason()
    {
        $response = $this->actingAs($this->editor)
                         ->post('/dashboard/editor/journals/reject-manuscript', [
                             'journal_uuid' => $this->journal->uuid,
                             // Missing reason
                         ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['reason']);
    }

    public function test_editorial_decision_request_revisions()
    {
        $response = $this->actingAs($this->editor)
                         ->post('/dashboard/editor/journals/request-revisions', [
                             'journal_uuid' => $this->journal->uuid,
                             'changes' => 'Please address the following issues: 1. Improve methodology section, 2. Add more references'
                         ]);

        $response->assertRedirect();
        $response->assertSessionHas('alert-type', 'success');
    }

    public function test_editorial_decision_request_revisions_requires_changes()
    {
        $response = $this->actingAs($this->editor)
                         ->post('/dashboard/editor/journals/request-revisions', [
                             'journal_uuid' => $this->journal->uuid,
                             // Missing changes
                         ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['changes']);
    }

    public function test_reviewed_journals_page_shows_pending_decisions()
    {        // Set journal status to reviewed
        $this->journal->update(['approval_status' => 'reviewed']);

        $response = $this->actingAs($this->editor)
                         ->get('/dashboard/editor/journals/reviewed');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.editor.journals.showReviewedJournals');
        $response->assertSee($this->journal->title);
        $response->assertSee('Ready for Decision');
    }

    public function test_enhanced_review_form_displays_correctly()
    {        // Assign reviewer to journal
        Reviewer::create([
            'journal_id' => $this->journal->id,
            'reviewer_id' => $this->reviewer1->id
        ]);

        $response = $this->actingAs($this->reviewer1)
                         ->get("/dashboard/reviewer/journals/{$this->journal->uuid}/enhanced-review");

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.reviewer.journals.enhanced-review');
        $response->assertSee('Enhanced Review Form');
        $response->assertSee('Overall Rating');
        $response->assertSee('Editorial Recommendation');
    }    public function test_basic_workflow_pages_load_correctly()
    {
        // Debug the journal data first
        dump('Journal UUID: ' . $this->journal->uuid);
        dump('Journal Slug: ' . $this->journal->slug);
        
        // Test that basic pages load without authentication errors
        $response = $this->actingAs($this->editor)
                         ->get("/dashboard/editor/journals/{$this->journal->uuid}/{$this->journal->slug}");

        // Debug the response if it's not 200
        if ($response->status() !== 200) {
            dump('Response status: ' . $response->status());
            dump('URL requested: ' . "/dashboard/editor/journals/{$this->journal->uuid}/{$this->journal->slug}");
        }

        // Just test that the page loads (status 200) without role-based permissions for now
        $response->assertStatus(200);
    }
}
