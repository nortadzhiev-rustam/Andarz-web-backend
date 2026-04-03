<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
class AuthorController extends Controller {
    public function __construct(private readonly AuthorService $authorService) {}
    public function index(Request $request): AnonymousResourceCollection {
        return AuthorResource::collection($this->authorService->getAll((int)$request->query('per_page',15)));
    }
    public function store(StoreAuthorRequest $request): JsonResponse {
        return response()->json(['message'=>'Author created successfully.','data'=>new AuthorResource($this->authorService->create($request->validated()))],201);
    }
    public function show(int $id): JsonResponse {
        return response()->json(['data'=>new AuthorResource($this->authorService->findById($id))]);
    }
    public function update(UpdateAuthorRequest $request, int $id): JsonResponse {
        return response()->json(['message'=>'Author updated successfully.','data'=>new AuthorResource($this->authorService->update($id,$request->validated()))]);
    }
    public function destroy(int $id): JsonResponse {
        $this->authorService->delete($id);
        return response()->json(['message'=>'Author deleted successfully.']);
    }
}
