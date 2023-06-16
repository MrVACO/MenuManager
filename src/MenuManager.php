<?php

namespace MrVaco\MenuManager;

use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class MenuManager extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot(): void
    {
        Nova::script('menu-manager', __DIR__ . '/../dist/js/tool.js');
        Nova::style('menu-manager', __DIR__ . '/../dist/css/tool.css');
    }
    
    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function menu(Request $request) {}
}
