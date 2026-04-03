<?php
namespace App\Repositories\Contracts;
use App\Models\Quote;
use Illuminate\Pagination\LengthAwarePaginator;
interface QuoteRepositoryInterface extends RepositoryInterface {
    public function getActive(int $perPage = 15): LengthAwarePaginator;
    public function getFeatured(int $perPage = 15): LengthAwarePaginator;
    public function getByCategory(int $categoryId, int $perPage = 15): LengthAwarePaginator;
    public function getByAuthor(int $authorId, int $perPage = 15): LengthAwarePaginator;
    public function getRandom(): ?Quote;
}
