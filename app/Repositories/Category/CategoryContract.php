<?php
namespace App\Repositories\Category;
interface CategoryContract {
    public function getAll();
    public function findById($id);
    public function findBySlug($slug);
    public function findByUUID($id);
    public function create($request);
    public function update($request, $id);
    public function delete($id);
}
