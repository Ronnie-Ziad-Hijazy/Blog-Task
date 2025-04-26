<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\ActivityLogService;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Category Construct
     *
     * @param \App\Services\CategoryService $categoryService
     */
    public function __construct(private readonly CategoryService $categoryService) {}

    /**
     * Retrieve Categories
     *
     * @return void
     */
    public function index() : JsonResponse {
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
        $category = $this->findCategoryOrFail($id);

        // Log activity
        ActivityLogService::log('READ', class_basename(Category::class), $category->id, null);
        
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

        // Log activity
        ActivityLogService::log('CREATE', class_basename(Category::class), $category->id, null);

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
        $category = $this->findCategoryOrFail($id);

        $newCategory = $this->categoryService->updateCategory($categoryRequest->validated() , $id);

        // Log activity with changed fields
        $changedFields = json_encode(array_diff_assoc($categoryRequest->validated(), $category->toArray()));

        if (!empty($changedFields)) {
            ActivityLogService::log('UPDATE', class_basename(Category::class), $category->id, $changedFields);
        }

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
        $category = $this->findCategoryOrFail($id);

        // delete category
        $deleteCategory = $this->categoryService->deleteCategory($id);

        // Log activity
        ActivityLogService::log('DELETE', class_basename(Category::class), $category->id, null);

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted.',
            'category' => $deleteCategory
        ]);
    }

    /**
     * Find Category By Id
     *
     * @param [type] $id
     *
     * @return \App\Models\Category
     */
    private function findCategoryOrFail($id): Category{
        $category = Category::find($id);

        if (!$category) {
            abort(response()->json([
                'success' => false,
                'message' => 'Category not found.',
            ], 404));
        }

        return $category;
    }
}
