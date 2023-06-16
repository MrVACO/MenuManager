<?php

namespace MrVaco\MenuManager;

use Illuminate\Http\Request;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Tool;
use MrVaco\MenuManager\Resources\MenuNovaResource;

class MenuManager extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot(): void {}
    
    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function menu(Request $request): mixed
    {
        return MenuSection::make(MenuNovaResource::label())
            ->path('/resources/' . MenuNovaResource::uriKey())
            ->icon('menu-alt-1');
    }
}
