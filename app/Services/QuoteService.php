<?php
namespace App\Services;
use App\Models\Quote;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
class QuoteService {
    public function __construct(private readonly QuoteRepositoryInterface $quoteRepository) {}
    public function getAll(int $perPage = 15): LengthAwarePaginator { return $this->quoteRepository->getActive($perPage); }
    public function getFeatured(int $perPage = 15): LengthAwarePaginator { return $this->quoteRepository->getFeatured($perPage); }
    public function getByCategory(int $categoryId, int $perPage = 15): LengthAwarePaginator { return $this->quoteRepository->getByCategory($categoryId,$perPage); }
    public function getByAuthor(int $authorId, int $perPage = 15): LengthAwarePaginator { return $this->quoteRepository->getByAuthor($authorId,$perPage); }
    public function getRandom(): ?Quote { return $this->quoteRepository->getRandom(); }
    public function findById(int $id): Quote { return $this->quoteRepository->findOrFail($id); }
    public function create(array $data): Quote { return $this->quoteRepository->create($data); }
    public function update(int $id, array $data): Quote { return $this->quoteRepository->update($id,$data); }
    public function delete(int $id): bool { return $this->quoteRepository->delete($id); }
}
