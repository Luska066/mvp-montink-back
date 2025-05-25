<?php

namespace App\Providers;

use App\Models\Produto;
use App\Observers\ProdutoObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->defineObservers();
    }

    private function defineObservers()
    {
        Produto::observe(ProdutoObserver::class);
    }
}
