<?php
namespace App\Repositories\User;
interface UserContract {
    public function create($request);
    public function update($request, $uuid);
    public function getAll();
    public function findById($id);
    public function findByUuid($uuid);
    public function deleteById($id);
    public function getReviewers();
}
