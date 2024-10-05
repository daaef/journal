<?php
namespace App\Repositories\SubCategory;
use App\Repositories\SubCategory\SubCategoryContract;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class EloquentSubCategoryRepository implements SubCategoryContract {
    public function create($request) {
        $subCategory = new SubCategory();
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->slug = Str::slug($request->name, '-');
        $subCategory->uuid = Str::uuid();
        $subCategory->description = $request->description;
        $subCategory->is_active = true;
        $subCategory->save();
        return $subCategory;
    }

    public function update($request, $id) {
        $subCategory = $this->findByUUID($id);
        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category_id;
        $subCategory->slug = Str::slug($request->name, '-');
        $subCategory->uuid = Str::uuid();
        $subCategory->description = $request->description;
        $subCategory->is_active = $request->is_active == 1 ? true : false;
        $subCategory->save();
        return $subCategory;
    }

    public function destroy($id) {
        $subCategory = $this->findByUUID($id);
        $subCategory->delete();
        return $subCategory;
    }

    public function findById($id) {
        return SubCategory::findOrFail($id);
    }

    public function getAll() {
        return SubCategory::all();
    }

    public function findByUUID($uuid) {
        return SubCategory::where('uuid', $uuid)->first();
    }

    public function findByCategory($category_id) {
        return SubCategory::where('category_id', $category_id)->get();
    }

    public function delete($id){
        $category = $this->findByUUID($id);
        return $category->delete();
    }
}
