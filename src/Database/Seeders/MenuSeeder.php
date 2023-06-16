<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Database\Seeders;

use Illuminate\Database\Seeder;
use MrVaco\MenuManager\Models\Menu;
use MrVaco\SomeHelperCode\Enums\Status;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $topMenu = Menu::query()->create([
            'title'  => 'Главное меню',
            'slug'   => 'top-menu',
            'status' => Status::Active,
        ]);
        
        $mobileMenu = Menu::query()->create([
            'title'  => 'Мобильное меню',
            'slug'   => 'mobile-menu',
            'status' => Status::Disabled,
        ]);
        
        $footerMenu = Menu::query()->create([
            'title'  => 'Нижнее меню',
            'slug'   => 'footer-menu',
            'status' => Status::Disabled,
        ]);
        
        $topMenu->children()->create([
            'title'  => 'Главная страница',
            'slug'   => '/',
            'status' => Status::Active,
        ]);
    }
}
