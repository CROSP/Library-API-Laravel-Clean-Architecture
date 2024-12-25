<?php

namespace App\Providers;

use App\Contexts\Book\Domain\Contracts\BookMapperContract;
use App\Contexts\Book\Domain\Contracts\BookRepositoryContract;
use App\Contexts\Book\Infrastructure\Mappers\BookMapper;
use App\Contexts\Book\Infrastructure\Persistence\EloquentBookRepository;
use App\Contexts\User\Domain\Contracts\UserMapperContract;
use App\Contexts\User\Domain\Contracts\UserRepositoryContract;
use App\Contexts\User\Infrastructure\Mappers\UserMapper;
use App\Contexts\User\Infrastructure\Persistence\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->singleton(UserRepositoryContract::class, EloquentUserRepository::class);
        $this->app->singleton(BookRepositoryContract::class, EloquentBookRepository::class);
        $this->app->singleton(BookMapperContract::class, BookMapper::class);
        $this->app->singleton(UserMapperContract::class, UserMapper::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
