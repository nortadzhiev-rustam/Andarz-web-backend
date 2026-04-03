<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class CourseController extends Controller {
    public function __construct(private readonly CourseService $courseService) {}
    /** Returns Course[] array matching frontend expectation */
    public function index(Request $request): JsonResponse {
        $courses = $this->courseService->getAll(
            $request->query('category'),
            $request->query('level'),
            $request->has('featured') ? (bool) $request->query('featured') : null,
        );
        return response()->json(CourseResource::collection($courses)->resolve());
    }
    public function featured(): JsonResponse {
        return response()->json(CourseResource::collection($this->courseService->getFeatured())->resolve());
    }
    public function show(int $id): JsonResponse {
        return response()->json((new CourseResource($this->courseService->findById($id)))->resolve());
    }
    public function showBySlug(string $slug): JsonResponse {
        $course = $this->courseService->findBySlug($slug);
        if (!$course) return response()->json(['message' => 'Course not found.'], 404);
        return response()->json((new CourseResource($course))->resolve());
    }
    public function store(StoreCourseRequest $request): JsonResponse {
        return response()->json((new CourseResource($this->courseService->create($request->validated())))->resolve(), 201);
    }
    public function update(UpdateCourseRequest $request, int $id): JsonResponse {
        return response()->json((new CourseResource($this->courseService->update($id, $request->validated())))->resolve());
    }
    public function destroy(int $id): JsonResponse {
        $this->courseService->delete($id);
        return response()->json(['message' => 'Course deleted successfully.']);
    }
    public function enroll(Request $request, int $id): JsonResponse {
        $this->courseService->enroll($request->user(), $id);
        return response()->json(['message' => 'Enrolled successfully.']);
    }
}
