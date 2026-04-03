<?php
namespace App\Repositories\Contracts;
use App\Models\Course;
use Illuminate\Support\Collection;
interface CourseRepositoryInterface extends RepositoryInterface {
    public function getPublished(): Collection;
    public function getFeatured(): Collection;
    public function getByCategory(string $category): Collection;
    public function getByLevel(string $level): Collection;
    public function findBySlug(string $slug): ?Course;
    public function filter(?string $category, ?string $level, ?bool $featured): Collection;
}
