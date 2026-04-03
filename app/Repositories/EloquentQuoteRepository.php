<?php
namespace App\Repositories;
use App\Models\Quote;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
class EloquentQuoteRepository extends EloquentRepository implements QuoteRepositoryInterface {
    public function __construct(Quote $model) { parent::__construct($model); }
    public function getActive(int $perPage = 15): LengthAwarePaginator {
        return Quote::active()->with(['author','category'])->latest()->paginate($perPage);
    }
    public function getFeatured(int $perPage = 15): LengthAwarePaginator {
        return Quote::active()->featured()->with(['author','category'])->latest()->paginate($perPage);
    }
    public function getByCategory(int $categoryId, int $perPage = 15): LengthAwarePaginator {
        return Quote::active()->where('category_id',$categoryId)->with(['author','category'])->latest()->paginate($perPage);
    }
    public function getByAuthor(int $authorId, int $perPage = 15): LengthAwarePaginator {
        return Quote::active()->where('author_id',$authorId)->with(['author','category'])->latest()->paginate($perPage);
    }
    public function getRandom(): ?Quote { return Quote::active()->inRandomOrder()->first(); }
}
