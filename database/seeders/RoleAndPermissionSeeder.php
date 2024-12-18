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
        Permission::create(['name' => 'create-users', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'edit-users', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'delete-users', 'is_active' => true, 'uuid' => Str::uuid()]);

        Permission::create(['name' => 'create-publications', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'edit-publications', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'delete-publications', 'is_active' => true, 'uuid' => Str::uuid()]);

        Permission::create(['name' => 'create-posts', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'edit-posts', 'is_active' => true, 'uuid' => Str::uuid()]);
        Permission::create(['name' => 'delete-posts', 'is_active' => true, 'uuid' => Str::uuid()]);

        Permission::create(['name' => 'can-invite', 'is_active' => true, 'uuid' => Str::uuid()]);
        // Permission::create(['name' => 'edit-posts']);
        // Permission::create(['name' => 'delete-posts']);


        $adminRole = Role::create(['name' => 'Admin', 'is_active' => true, 'uuid' => Str::uuid()]);
        $editorRole = Role::create(['name' => 'Editor in Chief', 'is_active' => true, 'uuid' => Str::uuid()]);
        $authorRole = Role::create(['name' => 'Author', 'is_active' => true, 'uuid' => Str::uuid()]);
        // $contributorRole = Role::create(['name' => 'Contributor', 'is_active' => true, 'uuid' => Str::uuid()]);
        // $publisherRole = Role::create(['name' => 'Publisher', 'is_active' => true, 'uuid' => Str::uuid()]);
        $associateEditor = Role::create(['name' => 'Associate Editor', 'is_active' => true, 'uuid' => Str::uuid()]);

        // Role::create(['name' => 'Editor in Chief', 'is_active' => true, 'uuid' => Str::uuid()]);
        $managingEditor = Role::create(['name' => 'Managing Editor', 'is_active' => true, 'uuid' => Str::uuid()]);
        // Role::create(['name' => 'Associate Editor', 'is_active' => true, 'uuid' => Str::uuid()]);
        // Role::create(['name' => 'Peer Reviewer', 'is_active' => true, 'uuid' => Str::uuid()]);

        // $adminRole->givePermissionTo([
        //     'create-users',
        //     'edit-users',
        //     'delete-users',
        //     'create-roles',
        //     'edit-roles',
        //     'delete-roles',
        //     'create-permissions',
        //     'edit-permissions',
        //     'delete-permissions',
        //     'assign-associate-editors'
        // ]);

        // $editorRole->givePermissionTo([
        //     'assign-associate-editors',
        //     'approve-journal',
        //     'decline-journal',
        // ]);

        // $managingEditor->givePermissionTo([
        //     'assign-associate-editors',
        //     'approve-journal',
        //     'decline-journal',
        // ]);

        // $authorRole->givePermissionTo([
        //     'create-journal',
        //     'edit-journal',
        //     'delete-journal',
        // ]);

        // $associateEditor->givePermissionTo([
        //     'approve-journal',
        //     'decline-journal',
        //     'review-journal',
        // ]);
    }
}
