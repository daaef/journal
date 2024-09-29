<?php
namespace App\Repositories\Category;
use App\Repositories\Category\CategoryContract;
use App\Models\Category;
use Illuminate\Support\Str;

class EloquentCategoryRepository implements CategoryContract {
    public function getAll() {
        return Category::all();
    }

    public function findById($id){
        return Category::where('id', $id)->first();
    }

    public function findBySlug($slug) {
        return Category::where('slug', $slug)->first();
    }
    public function findByUUID($id) {
        return Category::where('uuid', $id)->first();
    }

    public function create($request) {
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->slug = Str::slug($request->name);
        $category->uuid = Str::uuid();
        $category->save();
        return $category;
    }

    public function update($request, $id) {
        $category = $this->findByUUID($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->slug = Str::slug($request->name);
        $category->save();
        return $category;
    }

    public function delete($id){
        $category = $this->findByUUID($id);
        return $category->delete();
    }
}
