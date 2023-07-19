<?php

namespace MrVaco\MenuManager;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use MrVaco\MenuManager\Nova\NovaMenuResource;

class MenuServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function()
        {
            $this->routes();
        });
        
        Nova::serving(function(ServingNova $event)
        {
            Nova::tools([new MenuManager]);
        });
        
        Lang::addJsonPath(__DIR__ . '/../lang');
    }
    
    public function register(): void
    {
        Nova::resources([
            NovaMenuResource::class
        ]);
    }
    
    protected function routes(): void
    {
        if ($this->app->routesAreCached())
        {
            return;
        }
        
        app('router')
            ->middleware('api')
            ->prefix('api/menu')
            ->group(__DIR__ . '/../routes/api.php');
    }
}
