<?php

namespace MrVaco\MenuManager;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use MrVaco\MenuManager\Resources\MenuNovaResource;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Nova::tools([new MenuManager]);
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        Nova::resources([
            MenuNovaResource::class
        ]);
    }
}
