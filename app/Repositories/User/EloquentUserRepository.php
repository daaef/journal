<?php
namespace App\Repositories\User;
use App\Repositories\User\UserContract;
use App\Models\User;

class EloquentUserRepository implements UserContract {

        /**
        * Create a new user.
        *
        * This method creates a new User instance with the given data
        * and saves it to the database.
        *
        * @param object $request The request object containing the user data
        * @return \App\Models\User The newly created User instance
        */
        public function create($request)
        {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            return $user;
        }

        /**
        * Update an existing user.
        *
        * This method finds a user by its ID, updates its data with the provided data,
        * and saves the changes to the database.
        *
        * @param int $id The ID of the user to update
        * @param object $request The request object containing the updated user data
        * @return \App\Models\User The updated User instance
        */
        public function update($id, $request)
        {
            $user = $this->findByUuid($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return $user;
        }

        /**
        * Retrieve all users.
        *
        * This method fetches all User records from the database.
        *
        * @return \Illuminate\Database\Eloquent\Collection Collection of all User models
        */
        public function getAll()
        {
            return User::all();
        }

        /**
        * Find a user by its ID.
        *
        * This method fetches a User record from the database by its ID.
        *
        * @param int $id The ID of the user to find
        * @return \App\Models\User The User instance with the given ID
        */
        public function findById($id)
        {
            return User::find($id);
        }

        /**
        * Find a user by its UUID.
        *
        * This method fetches a User record from the database by its UUID.
        *
        * @param string $uuid The UUID of the user to find
        * @return \App\Models\User The User instance with the given UUID
        */
        public function findByUuid($uuid)
        {
            return User::where('uuid', $uuid)->first();
        }

        /**
        * Delete a user.
        *
        * This method deletes a User record from the database by its ID.
        *
        * @param int $id The ID of the user to delete
        * @return bool True if the user was successfully deleted, false otherwise
        */
        public function deleteById($id)
        {
            return User::destroy($id);
        }
}
