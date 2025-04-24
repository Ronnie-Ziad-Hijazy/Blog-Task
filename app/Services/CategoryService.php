<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryService{

    public function createCategory(array $data){
        // business logic here
        return Category::create($data);
    }

    public function updateCategory(array $data , $id){
        // business logic here
        $newCategory = Category::find($id);
        $newCategory->update($data);
        return $newCategory->fresh();
    }

    public function deleteCategory($id){
        $deleteCategory = Category::findOrFail($id);
        $deleteCategory->delete();
        return $deleteCategory;
    }
}