<?php
namespace App\Repositories\SubSubCategory;
use App\Repositories\SubSubCategory\SubSubCategoryContract;
use App\Models\SubSubCategory;
use Illuminate\Support\Str;

class EloquentSubSubCategoryRepository implements SubSubCategoryContract {
    public function create($request) {
        $subCategory = new SubSubCategory();
        $subCategory->name = $request->name;
        $subCategory->sub_category_id = $request->sub_category_id;
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
        $subCategory->sub_category_id = $request->sub_category_id;
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
        return SubSubCategory::findOrFail($id);
    }

    public function getAll() {
        return SubSubCategory::all();
    }

    public function findByUUID($uuid) {
        return SubSubCategory::where('uuid', $uuid)->first();
    }

    public function delete($id){
        $category = $this->findByUUID($id);
        return $category->delete();
    }
}
