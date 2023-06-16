<?php

namespace MrVaco\MenuManager;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
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
        Nova::serving(function(ServingNova $event)
        {
            Nova::tools([new MenuManager]);
        });
        
        Lang::addJsonPath(__DIR__ . '/Lang');
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
