<?php
namespace App\Repositories;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Collection;
class EloquentCategoryRepository extends EloquentRepository implements CategoryRepositoryInterface {
    public function __construct(Category $model) { parent::__construct($model); }
    public function findBySlug(string $slug): ?Category { return Category::where('slug',$slug)->first(); }
    public function getActive(): Collection { return Category::where('is_active',true)->orderBy('name')->get(); }
}
