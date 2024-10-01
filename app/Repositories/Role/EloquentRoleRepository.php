<?php

namespace App\Repositories\Role;

use App\Repositories\Role\RoleContract;
use App\Models\Role;
use Illuminate\Support\Str;

class EloquentRoleRepository implements RoleContract
{

    /**
     * Create a new role.
     *
     * This method creates a new Role instance with the given name,
     * sets the guard to 'web', and saves it to the database.
     *
     * @param object $request The request object containing the role data
     * @return \App\Models\Role The newly created Role instance
     */
    public function create($request)
    {
        $role = new Role;
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->is_active = true;
        $role->uuid = Str::uuid();
        $role->save();
        return $role;
    }


    /**
     * Update an existing role.
     *
     * This method finds a role by its ID, updates its name with the provided data,
     * and saves the changes to the database.
     *
     * @param int $id The ID of the role to update
     * @param object $request The request object containing the updated role data
     * @return \App\Models\Role The updated Role instance
     */
    public function update($id, $request)
    {
        $role = $this->findByUuid($id);
        $role->name = $request->name;
        $role->is_active = $request->active_status;
        $role->save();
        return $role;
    }


    /**
     * Retrieve all roles.
     *
     * This method fetches all Role records from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of all Role models
     */
    public function getAll()
    {
        return Role::all();
    }

    /**
     * Find a role by its ID.
     *
     * @param int $id The ID of the role to find
     * @return \App\Models\Role|null The Role model if found, or null if not found
     */
    public function findById($id)
    {
        return Role::find($id);
    }

    /**
     * Find a role by its ID.
     *
     * @param int $id The ID of the role to find
     * @return \App\Models\Role|null The Role model if found, or null if not found
     */
    public function findByUuid($id)
    {
        return Role::where('uuid', $id)->first();
    }


    /**
     * Update a role by its ID.
     *
     * This method finds a role by its ID, updates its name with the provided data,
     * and saves the changes to the database.
     *
     * @param int $id The ID of the role to update
     * @param object $request The request object containing the updated role data
     * @return \App\Models\Role The updated Role instance
     */
    public function updateById($id, $request)
    {
        $role = $this->findById($id);
        $role->name = $request->name;
        $role->is_active = $request->is_active;
        $role->save();
        return $role;
    }


    /**
     * Delete a role by its ID.
     *
     * This method finds a role by its ID and deletes it from the database.
     *
     * @param int $id The ID of the role to delete
     * @return void
     */
    public function deleteById($id)
    {
        $role = $this->findById($id);
        if($role->delete()) {
            return true;
        }
        return false;
    }
}
