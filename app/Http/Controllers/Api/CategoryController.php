<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
class CategoryController extends Controller {
    public function __construct(private readonly CategoryService $categoryService) {}
    public function index(Request $request): AnonymousResourceCollection {
        return CategoryResource::collection($this->categoryService->getAll((int)$request->query('per_page',15)));
    }
    public function store(StoreCategoryRequest $request): JsonResponse {
        return response()->json(['message'=>'Category created successfully.','data'=>new CategoryResource($this->categoryService->create($request->validated()))],201);
    }
    public function show(int $id): JsonResponse {
        return response()->json(['data'=>new CategoryResource($this->categoryService->findById($id))]);
    }
    public function update(UpdateCategoryRequest $request, int $id): JsonResponse {
        return response()->json(['message'=>'Category updated successfully.','data'=>new CategoryResource($this->categoryService->update($id,$request->validated()))]);
    }
    public function destroy(int $id): JsonResponse {
        $this->categoryService->delete($id);
        return response()->json(['message'=>'Category deleted successfully.']);
    }
}
