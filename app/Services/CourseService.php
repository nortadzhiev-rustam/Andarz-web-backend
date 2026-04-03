<?php
namespace App\Services;
use App\Models\Course;
use App\Models\User;
use App\Repositories\Contracts\CourseRepositoryInterface;
use Illuminate\Support\Collection;
class CourseService {
    public function __construct(private readonly CourseRepositoryInterface $courseRepository) {}
    public function getAll(?string $category = null, ?string $level = null, ?bool $featured = null): Collection {
        return $this->courseRepository->filter($category, $level, $featured);
    }
    public function getFeatured(): Collection { return $this->courseRepository->getFeatured(); }
    public function findById(int $id): Course { return $this->courseRepository->findOrFail($id); }
    public function findBySlug(string $slug): ?Course { return $this->courseRepository->findBySlug($slug); }
    public function create(array $data): Course { return $this->courseRepository->create($data); }
    public function update(int $id, array $data): Course { return $this->courseRepository->update($id, $data); }
    public function delete(int $id): bool { return $this->courseRepository->delete($id); }
    public function enroll(User $user, int $courseId): void {
        $course = $this->findById($courseId);
        if (!$user->enrolledCourses()->where('course_id', $courseId)->exists()) {
            $user->enrolledCourses()->attach($courseId);
            $course->increment('students_count');
        }
    }
}
