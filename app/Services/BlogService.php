<?php
namespace App\Services;
use App\Models\BlogPost;
use App\Repositories\Contracts\BlogPostRepositoryInterface;
use Illuminate\Support\Collection;
class BlogService {
    public function __construct(private readonly BlogPostRepositoryInterface $blogPostRepository) {}
    public function getAll(): Collection { return $this->blogPostRepository->getAll(); }
    public function findBySlug(string $slug): ?BlogPost { return $this->blogPostRepository->findBySlug($slug); }
    public function findById(int $id): BlogPost { return $this->blogPostRepository->findOrFail($id); }
    public function create(array $data): BlogPost { return $this->blogPostRepository->create($data); }
    public function update(int $id, array $data): BlogPost { return $this->blogPostRepository->update($id, $data); }
    public function delete(int $id): bool { return $this->blogPostRepository->delete($id); }
}
