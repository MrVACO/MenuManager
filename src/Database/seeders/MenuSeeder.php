<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Database\Seeders;

use Illuminate\Database\Seeder;
use MrVaco\MenuManager\Models\Menu;
use MrVaco\NovaStatusesManager\Classes\StatusClass;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $topMenu = Menu::query()->create([
            'title'  => 'Main menu',
            'slug'   => 'top-menu',
            'status' => StatusClass::ACTIVE()->id,
        ]);
        
        $mobileMenu = Menu::query()->create([
            'title'  => 'Mobile menu',
            'slug'   => 'mobile-menu',
            'status' => StatusClass::DISABLED()->id,
        ]);
        
        $footerMenu = Menu::query()->create([
            'title'  => 'Bottom menu',
            'slug'   => 'footer-menu',
            'status' => StatusClass::DISABLED()->id,
        ]);
        
        $topMenu->children()->create([
            'title'  => 'Main page',
            'slug'   => '/',
            'status' => StatusClass::ACTIVE()->id,
        ]);
    }
}
