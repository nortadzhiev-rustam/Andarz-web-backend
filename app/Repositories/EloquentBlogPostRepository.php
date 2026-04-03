<?php
namespace App\Repositories;
use App\Models\BlogPost;
use App\Repositories\Contracts\BlogPostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
class EloquentBlogPostRepository extends EloquentRepository implements BlogPostRepositoryInterface {
    public function __construct(BlogPost $model) { parent::__construct($model); }
    public function getPublished(int $perPage = 15): LengthAwarePaginator { return BlogPost::published()->with('author')->latest('published_at')->paginate($perPage); }
    public function findBySlug(string $slug): ?BlogPost { return BlogPost::where('slug',$slug)->with('author')->first(); }
    public function getAll(): Collection { return BlogPost::published()->with('author')->latest('published_at')->get(); }
}
