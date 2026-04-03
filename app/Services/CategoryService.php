<?php
namespace App\Services;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
class CategoryService {
    public function __construct(private readonly CategoryRepositoryInterface $categoryRepository) {}
    public function getAll(int $perPage = 15): LengthAwarePaginator { return $this->categoryRepository->paginate($perPage); }
    public function getActive(): Collection { return $this->categoryRepository->getActive(); }
    public function findById(int $id): Category { return $this->categoryRepository->findOrFail($id); }
    public function findBySlug(string $slug): ?Category { return $this->categoryRepository->findBySlug($slug); }
    public function create(array $data): Category { return $this->categoryRepository->create($data); }
    public function update(int $id, array $data): Category { return $this->categoryRepository->update($id,$data); }
    public function delete(int $id): bool { return $this->categoryRepository->delete($id); }
}
