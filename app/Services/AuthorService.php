<?php
namespace App\Services;
use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
class AuthorService {
    public function __construct(private readonly AuthorRepositoryInterface $authorRepository) {}
    public function getAll(int $perPage = 15): LengthAwarePaginator { return $this->authorRepository->paginate($perPage); }
    public function getActive(): Collection { return $this->authorRepository->getActive(); }
    public function findById(int $id): Author { return $this->authorRepository->findOrFail($id); }
    public function findBySlug(string $slug): ?Author { return $this->authorRepository->findBySlug($slug); }
    public function create(array $data): Author { return $this->authorRepository->create($data); }
    public function update(int $id, array $data): Author { return $this->authorRepository->update($id,$data); }
    public function delete(int $id): bool { return $this->authorRepository->delete($id); }
}
