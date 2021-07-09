<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Repositories\ProductRepositoryInterface',
            'App\Repositories\ProductRepository'
        );

        // $this->app->bind(
        //     'App\Repositories\CommentRepositoryInterface',
        //     'App\Repositories\CommentRepository'
        // );
    }
}
