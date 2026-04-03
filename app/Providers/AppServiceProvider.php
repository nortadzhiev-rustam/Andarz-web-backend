<?php
namespace App\Providers;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EloquentAuthorRepository;
use App\Repositories\EloquentCategoryRepository;
use App\Repositories\EloquentQuoteRepository;
use App\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->bind(QuoteRepositoryInterface::class, EloquentQuoteRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, EloquentCategoryRepository::class);
        $this->app->bind(AuthorRepositoryInterface::class, EloquentAuthorRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }
    public function boot(): void {}
}
