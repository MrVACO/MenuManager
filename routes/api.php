<?php

use MrVaco\MenuManager\Http\Controllers\MenuController;

app('router')
    ->controller(MenuController::class)
    ->group(function()
    {
        app('router')->get('{slug}', 'single');
    });
