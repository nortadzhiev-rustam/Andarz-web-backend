<?php
namespace App\Repositories\Contracts;
use App\Models\BlogPost;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
interface BlogPostRepositoryInterface extends RepositoryInterface {
    public function getPublished(int $perPage = 15): LengthAwarePaginator;
    public function findBySlug(string $slug): ?BlogPost;
    public function getAll(): Collection;
}
