<?php

namespace App\Providers;

use App\Repositories\ProdutoRepository;
use App\Repositories\ProdutoRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProdutoRepository::class, ProdutoRepositoryEloquent::class);
    }
}
