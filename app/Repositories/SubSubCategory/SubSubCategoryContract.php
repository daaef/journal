<?php
namespace App\Repositories\SubSubCategory;
interface SubSubCategoryContract {
    public function create($request);
    public function update($request, $id);
    public function destroy($id);
    public function findById($id);
    public function getAll();
    public function findByUUID($uuid);
    public function delete($id);
}
