<?php
namespace App\Repositories\Contracts;
use App\Models\Author;
use Illuminate\Support\Collection;
interface AuthorRepositoryInterface extends RepositoryInterface {
    public function findBySlug(string $slug): ?Author;
    public function getActive(): Collection;
}
