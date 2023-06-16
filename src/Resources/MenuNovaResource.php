<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use MrVaco\MenuManager\Models\Menu;

class MenuNovaResource extends Resource
{
    public static function uriKey(): string
    {
        return 'menu';
    }
    
    public static $displayInNavigation = false;
    
    public static string $model = Menu::class;
    
    public static $title = 'title';
    
    public static $search = [
        'title'
    ];
    
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            
            BelongsTo::make('Parent', 'parent', self::class),
            HasMany::make('Child', 'children', self::class),
            
            Text::make('Title')->sortable(),
        ];
    }
}
