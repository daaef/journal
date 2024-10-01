<?php
namespace App\Repositories\Role;
interface RoleContract {
    public function create($request);
    public function update($id, $request);
    public function getAll();
    public function findById($id);
    public function findByUuid($id);
    public function deleteById($id);
}
