<?php
namespace App\Repositories;
use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Support\Collection;
class EloquentAuthorRepository extends EloquentRepository implements AuthorRepositoryInterface {
    public function __construct(Author $model) { parent::__construct($model); }
    public function findBySlug(string $slug): ?Author { return Author::where('slug',$slug)->first(); }
    public function getActive(): Collection { return Author::where('is_active',true)->orderBy('name')->get(); }
}
