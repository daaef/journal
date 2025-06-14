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
        Permission::create(['name' => 'create-users', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'edit-users', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'delete-users', 'is_active' => true, 'uuid' => Str::uuid()]);

        // Manuscript Management Permissions
        Permission::create(['name' => 'submit-manuscript', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'edit-own-manuscript', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'upload-revision', 'is_active' => true, 'uuid' => Str::uuid()]);

        // Associate Editor Permissions
        Permission::create(['name' => 'assign-reviewers', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'manage-review-process', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'request-revisions', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'coordinate-reviews', 'is_active' => true, 'uuid' => Str::uuid()]);

        // Editor/Managing Editor Permissions
        Permission::create(['name' => 'assign-associate-editors', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'send-approval-notice', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'send-decline-notice', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'final-approve-manuscript', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'final-reject-manuscript', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'publish-manuscript', 'is_active' => true, 'uuid' => Str::uuid()]);
        
        // Copy Desk Editor Permissions
        Permission::create(['name' => 'copy-edit-manuscript', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'final-edit-manuscript', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'prepare-for-publication', 'is_active' => true, 'uuid' => Str::uuid()]);

        // Reviewer Permissions
        Permission::create(['name' => 'review-manuscript', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'provide-feedback', 'is_active' => true, 'uuid' => Str::uuid()]);

        // Legacy permissions
        Permission::create(['name' => 'create-publications', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'edit-publications', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'delete-publications', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'create-posts', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'edit-posts', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'delete-posts', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'can-invite', 'is_active' => true, 'uuid' => Str::uuid()]);

        // Create Roles
        $adminRole = Role::create(['name' => 'Admin', 'is_active' => true, 'uuid' => Str::uuid()]);
        $editorInChiefRole = Role::create(['name' => 'Editor in Chief', 'is_active' => true, 'uuid' => Str::uuid()]);
        $managingEditorRole = Role::create(['name' => 'Managing Editor', 'is_active' => true, 'uuid' => Str::uuid()]);
        $associateEditorRole = Role::create(['name' => 'Associate Editor', 'is_active' => true, 'uuid' => Str::uuid()]);
        $externalReviewerRole = Role::create(['name' => 'External Reviewer', 'is_active' => true, 'uuid' => Str::uuid()]);
        $authorRole = Role::create(['name' => 'Author', 'is_active' => true, 'uuid' => Str::uuid()]);
        $deskEditorRole = Role::create(['name' => 'Desk Editor', 'is_active' => true, 'uuid' => Str::uuid()]);
        $copyDeskEditorRole = Role::create(['name' => 'Copy Desk Editor', 'is_active' => true, 'uuid' => Str::uuid()]);

        // Assign Permissions to Roles

        // Admin - Full access
        $adminRole->givePermissionTo([
            'create-users', 'edit-users', 'delete-users',
            'assign-associate-editors', 'final-approve-manuscript', 'final-reject-manuscript',
            'publish-manuscript', 'create-publications', 'edit-publications', 'delete-publications'
        ]);

        // Editor in Chief - Strategic oversight and final decisions
        $editorInChiefRole->givePermissionTo([
            'assign-associate-editors', 'final-approve-manuscript', 'final-reject-manuscript',
            'publish-manuscript'
        ]);

        // Managing Editor - Operational management and sends notices
        $managingEditorRole->givePermissionTo([
            'assign-associate-editors', 'send-approval-notice', 'send-decline-notice'
        ]);

        // Associate Editor - Review process management (Peer Reviewers)
        $associateEditorRole->givePermissionTo([
            'assign-reviewers', 'manage-review-process', 'request-revisions',
            'coordinate-reviews', 'review-manuscript', 'provide-feedback'
        ]);

        // External Reviewer - Review and feedback only
        $externalReviewerRole->givePermissionTo([
            'review-manuscript', 'provide-feedback'
        ]);

        // Author - Manuscript submission and revision
        $authorRole->givePermissionTo([
            'submit-manuscript', 'edit-own-manuscript', 'upload-revision'
        ]);

        // Desk Editor - Administrative support
        $deskEditorRole->givePermissionTo([
            'review-manuscript', 'provide-feedback'
        ]);
        
        // Copy Desk Editor - Final editing and publication preparation
        $copyDeskEditorRole->givePermissionTo([
            'copy-edit-manuscript', 'final-edit-manuscript', 'prepare-for-publication'
        ]);
    }
}
