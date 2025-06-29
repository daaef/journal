<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Basic User Management Permissions
        Permission::firstOrCreate(['name' => 'create-users'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'edit-users'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'delete-users'], ['is_active' => true, 'uuid' => Str::uuid()]);

        // Manuscript Management Permissions
        Permission::firstOrCreate(['name' => 'submit-manuscript'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'edit-own-manuscript'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'upload-revision'], ['is_active' => true, 'uuid' => Str::uuid()]);

        // Associate Editor Permissions
        Permission::firstOrCreate(['name' => 'assign-reviewers'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'manage-review-process'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'request-revisions'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'coordinate-reviews'], ['is_active' => true, 'uuid' => Str::uuid()]);

        // Editor/Managing Editor Permissions
        Permission::firstOrCreate(['name' => 'assign-associate-editors'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'send-approval-notice'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'send-decline-notice'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'final-approve-manuscript'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'final-reject-manuscript'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'publish-manuscript'], ['is_active' => true, 'uuid' => Str::uuid()]);

        // Copy Desk Editor Permissions
        Permission::firstOrCreate(['name' => 'copy-edit-manuscript'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'final-edit-manuscript'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'prepare-for-publication'], ['is_active' => true, 'uuid' => Str::uuid()]);

        // Reviewer Permissions
        Permission::firstOrCreate(['name' => 'review-manuscript'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'provide-feedback'], ['is_active' => true, 'uuid' => Str::uuid()]);

        // Legacy permissions
        Permission::firstOrCreate(['name' => 'create-publications'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'edit-publications'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'delete-publications'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'create-posts'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'edit-posts'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'delete-posts'], ['is_active' => true, 'uuid' => Str::uuid()]);
        Permission::firstOrCreate(['name' => 'can-invite'], ['is_active' => true, 'uuid' => Str::uuid()]);

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin'], ['is_active' => true, 'uuid' => Str::uuid()]);
        $editorInChiefRole = Role::firstOrCreate(['name' => 'Editor in Chief'], ['is_active' => true, 'uuid' => Str::uuid()]);
        $managingEditorRole = Role::firstOrCreate(['name' => 'Managing Editor'], ['is_active' => true, 'uuid' => Str::uuid()]);
        $associateEditorRole = Role::firstOrCreate(['name' => 'Associate Editor'], ['is_active' => true, 'uuid' => Str::uuid()]);
        $externalReviewerRole = Role::firstOrCreate(['name' => 'External Reviewer'], ['is_active' => true, 'uuid' => Str::uuid()]);
        $authorRole = Role::firstOrCreate(['name' => 'Author'], ['is_active' => true, 'uuid' => Str::uuid()]);
        $deskEditorRole = Role::firstOrCreate(['name' => 'Desk Editor'], ['is_active' => true, 'uuid' => Str::uuid()]);
        $copyDeskEditorRole = Role::firstOrCreate(['name' => 'Copy Desk Editor'], ['is_active' => true, 'uuid' => Str::uuid()]);

        // Assign Permissions to Roles (using sync to avoid duplicates)

        // Admin - Full access
        $adminRole->syncPermissions([
            'create-users', 'edit-users', 'delete-users',
            'assign-associate-editors', 'final-approve-manuscript', 'final-reject-manuscript',
            'publish-manuscript', 'create-publications', 'edit-publications', 'delete-publications'
        ]);

        // Editor in Chief - Strategic oversight and final decisions
        $editorInChiefRole->syncPermissions([
            'assign-associate-editors', 'final-approve-manuscript', 'final-reject-manuscript',
            'publish-manuscript'
        ]);

        // Managing Editor - Operational management and sends notices
        $managingEditorRole->syncPermissions([
            'assign-associate-editors', 'send-approval-notice', 'send-decline-notice'
        ]);

        // Associate Editor - Review process management (Peer Reviewers)
        $associateEditorRole->syncPermissions([
            'assign-reviewers', 'manage-review-process', 'request-revisions',
            'coordinate-reviews', 'review-manuscript', 'provide-feedback'
        ]);

        // External Reviewer - Review and feedback only
        $externalReviewerRole->syncPermissions([
            'review-manuscript', 'provide-feedback'
        ]);

        // Author - Manuscript submission and revision
        $authorRole->syncPermissions([
            'submit-manuscript', 'edit-own-manuscript', 'upload-revision'
        ]);

        // Desk Editor - Editorial desk management
        $deskEditorRole->syncPermissions([
            'manage-review-process', 'coordinate-reviews'
        ]);

        // Copy Desk Editor - Final editing and preparation
        $copyDeskEditorRole->syncPermissions([
            'copy-edit-manuscript', 'final-edit-manuscript', 'prepare-for-publication'
        ]);
    }
}
