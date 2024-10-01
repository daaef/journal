<?php
namespace App\Repositories\User;
interface UserContract {
    public function create($request);
    public function update($id, $request);
    public function getAll();
    public function findById($id);
    public function findByUuid($id);
    public function deleteById($id);
}
