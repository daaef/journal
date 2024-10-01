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
        $editorRole = Role::create(['name' => 'Editor', 'is_active' => true, 'uuid' => Str::uuid()]);
        $authorRole = Role::create(['name' => 'Author', 'is_active' => true, 'uuid' => Str::uuid()]);
        $contributorRole = Role::create(['name' => 'Contributor', 'is_active' => true, 'uuid' => Str::uuid()]);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-publications',
            'edit-publications',
            'delete-publications',
        ]);

        $editorRole->givePermissionTo([
            'create-publications',
            'edit-publications',
            'delete-publications',
        ]);

        $authorRole->givePermissionTo([
            'create-publications',
            'edit-publications',
            'delete-publications',
        ]);

        $contributorRole->givePermissionTo([
            'create-posts',
            'edit-posts',
            'delete-posts',
        ]);
    }
}
