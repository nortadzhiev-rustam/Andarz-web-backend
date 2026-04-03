<?php
namespace App\Repositories;
use App\Models\Course;
use App\Repositories\Contracts\CourseRepositoryInterface;
use Illuminate\Support\Collection;
class EloquentCourseRepository extends EloquentRepository implements CourseRepositoryInterface {
    public function __construct(Course $model) { parent::__construct($model); }
    private function withRelations(): \Illuminate\Database\Eloquent\Builder { return Course::with(['instructor','modules.lessons']); }
    public function getPublished(): Collection { return $this->withRelations()->published()->orderByDesc('id')->get(); }
    public function getFeatured(): Collection { return $this->withRelations()->published()->featured()->orderByDesc('id')->get(); }
    public function getByCategory(string $category): Collection { return $this->withRelations()->published()->where('category',$category)->orderByDesc('id')->get(); }
    public function getByLevel(string $level): Collection { return $this->withRelations()->published()->where('level',$level)->orderByDesc('id')->get(); }
    public function findBySlug(string $slug): ?Course { return $this->withRelations()->where('slug',$slug)->first(); }
    public function filter(?string $category, ?string $level, ?bool $featured): Collection {
        $q = $this->withRelations()->published();
        if ($category && $category !== 'All') $q->where('category', $category);
        if ($level && $level !== 'All') $q->where('level', $level);
        if ($featured !== null) $q->where('is_featured', $featured);
        return $q->orderByDesc('id')->get();
    }
}
