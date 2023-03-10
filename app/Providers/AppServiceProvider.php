<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\PostRepositoryInterface', 
            'App\Repositories\Eloquent\PostRepository', 
        );

        $this->app->bind(
            'App\Repositories\Contracts\CommentRepositoryInterface', 
            'App\Repositories\Eloquent\CommentRepository', 
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
