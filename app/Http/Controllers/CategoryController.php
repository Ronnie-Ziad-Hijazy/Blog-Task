<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    private $categoryService;

    /**
     * Category Construct
     *
     * @param \App\Services\CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
    $this->categoryService = $categoryService;
    }

    /**
     * Retrieve Categories
     *
     * @return void
     */
    public function index(){
        return response()->json(Category::paginate(10));
    }

    /**
     * Show Func
     *
     * @param [type] $id
     *
     * @return void
     */
    public function show($id){
        $category = Category::find($id);

        if(!$category){
            return $this->fireError("Category not found." , 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Category retrieved successfully.',
            'category' => $category
        ]);
    }

    /**
     * Category Store
     *
     * @param \App\Http\Requests\CategoryRequest $categoryRequest
     *
     * @return void
     */
    public function store(CategoryRequest $categoryRequest){
        $category = $this->categoryService->createCategory($categoryRequest->validated());

        return response()->json([
            "success" => true,
            "message" => "Category Created.",
            "category" => $category
        ],201);

    }

    /**
     * Category Update
     *
     * @param \App\Http\Requests\CategoryRequest $categoryRequest
     * @param integer $id
     *
     * @return void
     */
    public function update(CategoryRequest $categoryRequest , int $id){
        $category = Category::find($id);

        if(!$category){
            return $this->fireError("Category not found." , 404);
        }
        $newCategory = $this->categoryService->updateCategory($categoryRequest->validated() , $id);

        return response()->json([
            "success" => true,
            "message" => "Category Updated.",
            "category" => $newCategory
        ]);
    }

    /**
     * Category Destroy
     *
     * @param [type] $id
     *
     * @return void
     */
    public function destroy($id){
        $category = Category::find($id);

        if(!$category){
            return $this->fireError("Category not found." , 404);
        }

        // delete category
        $deleteCategory = $this->categoryService->deleteCategory($id);

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted.',
            'category' => $deleteCategory
        ]);
    }
}
