<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogPostRequest;
use App\Http\Requests\Blog\UpdateBlogPostRequest;
use App\Http\Resources\BlogPostResource;
use App\Services\BlogService;
use Illuminate\Http\JsonResponse;
class BlogController extends Controller {
    public function __construct(private readonly BlogService $blogService) {}
    public function index(): JsonResponse {
        return response()->json(BlogPostResource::collection($this->blogService->getAll())->resolve());
    }
    public function show(int $id): JsonResponse {
        return response()->json((new BlogPostResource($this->blogService->findById($id)))->resolve());
    }
    public function showBySlug(string $slug): JsonResponse {
        $post = $this->blogService->findBySlug($slug);
        if (!$post) return response()->json(['message' => 'Blog post not found.'], 404);
        return response()->json((new BlogPostResource($post))->resolve());
    }
    public function store(StoreBlogPostRequest $request): JsonResponse {
        return response()->json((new BlogPostResource($this->blogService->create($request->validated())))->resolve(), 201);
    }
    public function update(UpdateBlogPostRequest $request, int $id): JsonResponse {
        return response()->json((new BlogPostResource($this->blogService->update($id, $request->validated())))->resolve());
    }
    public function destroy(int $id): JsonResponse {
        $this->blogService->delete($id);
        return response()->json(['message' => 'Blog post deleted successfully.']);
    }
}
