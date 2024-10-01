<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'create-publications']);
        Permission::create(['name' => 'edit-publications']);
        Permission::create(['name' => 'delete-publications']);

        Permission::create(['name' => 'create-posts']);
        Permission::create(['name' => 'edit-posts']);
        Permission::create(['name' => 'delete-posts']);

        Permission::create(['name' => 'can-invite']);
        // Permission::create(['name' => 'edit-posts']);
        // Permission::create(['name' => 'delete-posts']);


        $adminRole = Role::create(['name' => 'Admin']);
        $editorRole = Role::create(['name' => 'Editor']);
        $authorRole = Role::create(['name' => 'Author']);
        $contributorRole = Role::create(['name' => 'Contributor']);

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
