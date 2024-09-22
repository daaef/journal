<?php
namespace App\Repositories\Category;
use App\Repositories\Category\CategoryContract;
use App\Models\Category;

class EloquentCategoryRepository implements CategoryContract {
    public function getAll() {
        return Category::all();
    }

    public function findById($id){
        return Category::where('id', $id)->first();
    }

    public function create($request) {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return $category;
    }

    public function update($request, $id) {
        $category = $this->findById($id);
        $category->name = $request->name;
        $category->save();
        return $category;
    }

    public function delete($id){
        $category = $this->findById($id);
        return $category->delete();
    }
}
