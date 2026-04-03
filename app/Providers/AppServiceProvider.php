<?php
namespace App\Providers;
use App\Repositories\Contracts\BlogPostRepositoryInterface;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Repositories\Contracts\InstructorRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EloquentBlogPostRepository;
use App\Repositories\EloquentCourseRepository;
use App\Repositories\EloquentInstructorRepository;
use App\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->bind(CourseRepositoryInterface::class, EloquentCourseRepository::class);
        $this->app->bind(BlogPostRepositoryInterface::class, EloquentBlogPostRepository::class);
        $this->app->bind(InstructorRepositoryInterface::class, EloquentInstructorRepository::class);
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
    }
    public function boot(): void {}
}
