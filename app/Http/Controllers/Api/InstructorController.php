<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Instructor\StoreInstructorRequest;
use App\Http\Requests\Instructor\UpdateInstructorRequest;
use App\Http\Resources\InstructorResource;
use App\Services\InstructorService;
use Illuminate\Http\JsonResponse;
class InstructorController extends Controller {
    public function __construct(private readonly InstructorService $instructorService) {}
    public function index(): JsonResponse {
        return response()->json(InstructorResource::collection($this->instructorService->getAll())->resolve());
    }
    public function show(int $id): JsonResponse {
        return response()->json((new InstructorResource($this->instructorService->findById($id)))->resolve());
    }
    public function store(StoreInstructorRequest $request): JsonResponse {
        return response()->json((new InstructorResource($this->instructorService->create($request->validated())))->resolve(), 201);
    }
    public function update(UpdateInstructorRequest $request, int $id): JsonResponse {
        return response()->json((new InstructorResource($this->instructorService->update($id, $request->validated())))->resolve());
    }
    public function destroy(int $id): JsonResponse {
        $this->instructorService->delete($id);
        return response()->json(['message' => 'Instructor deleted successfully.']);
    }
}
