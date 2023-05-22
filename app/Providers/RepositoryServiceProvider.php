<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // repo User
        $this->app->singleton(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserRepository::class
        );

        //Eloquent
        $this->app->singleton(
            \App\Repositories\TestRepositoryInterface::class,
            \App\Repositories\Eloquent\TestRepository::class
        );
        $this->app->singleton(
            \App\Repositories\TestRepositoryInterface::class,
            \App\Repositories\Eloquent\TestRepository::class
        );
        $this->app->singleton(
            \App\Repositories\TestRepositoryInterface::class,
            \App\Repositories\Eloquent\TestRepository::class
        );
        $this->app->singleton(
            \App\Repositories\TestRepositoryInterface::class,
            \App\Repositories\Eloquent\TestRepository::class
        );
        $this->app->singleton(
            \App\Repositories\BannerRepositoryInterface::class,
            \App\Repositories\Eloquent\BannerRepository::class
        );
        $this->app->singleton(
            \App\Repositories\RedirectRepositoryInterface::class,
            \App\Repositories\Eloquent\RedirectRepository::class
        );
        $this->app->singleton(
            \App\Repositories\PostRepositoryInterface::class,
            \App\Repositories\Eloquent\PostRepository::class
        );
        $this->app->singleton(
            \App\Repositories\PostCategoryRepositoryInterface::class,
            \App\Repositories\Eloquent\PostCategoryRepository::class
        );
        $this->app->singleton(
            \App\Repositories\PostCommentRepositoryInterface::class,
            \App\Repositories\Eloquent\PostCommentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\DemoRepositoryInterface::class,
            \App\Repositories\Eloquent\DemoRepository::class
        );
        $this->app->singleton(
            \App\Repositories\LogRepositoryInterface::class,
            \App\Repositories\Eloquent\LogRepository::class
        );
    }
}
