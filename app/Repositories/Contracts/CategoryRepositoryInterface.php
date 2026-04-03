<?php
namespace App\Repositories\Contracts;
use App\Models\Category;
use Illuminate\Support\Collection;
interface CategoryRepositoryInterface extends RepositoryInterface {
    public function findBySlug(string $slug): ?Category;
    public function getActive(): Collection;
}
