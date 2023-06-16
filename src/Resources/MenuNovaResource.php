<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;
use MrVaco\MenuManager\Models\Menu;
use MrVaco\SomeHelperCode\Enums\LinkTarget;
use MrVaco\SomeHelperCode\Enums\Status;

class MenuNovaResource extends Resource
{
    public static function uriKey(): string
    {
        return 'menu';
    }
    
    public static function label(): string
    {
        return __('Menu');
    }
    
    public static function singularLabel(): string
    {
        return __('menu item');
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
            
            BelongsTo::make(__('Parent item'), 'parent', self::class)
                ->sortable()
                ->nullable()
                ->rules('required'),
            
            HasMany::make(__('Child elements'), 'children', self::class)->sortable(),
            
            Stack::make(__('Title'), [
                Line::make(__('Title'), 'title')->asHeading(),
                Line::make(__('Slug'), 'slug')->asSmall(),
            ])
                ->sortable()
                ->onlyOnIndex(),
            
            Text::make(__('Title'), 'title')
                ->rules('required')
                ->hideFromIndex(),
            
            Slug::make(__('Slug'), 'slug')->from('title')->rules('required')
                ->hideFromIndex(),
            
            Text::make(__('Description'), 'description')
                ->hideFromIndex(),
            
            Text::make(__('Link target'), function()
            {
                return $this->link_target->trans();
            }),
            
            Select::make(__('Link target'), 'link_target')
                ->rules('required')
                ->options(LinkTarget::list())
                ->default(LinkTarget::Self)
                ->onlyOnForms(),
            
            Badge::make(__('Status'), 'status')
                ->addTypes([
                    0 => 'text-yellow-500',
                    1 => 'text-blue-500',
                    2 => 'text-gray-400',
                    3 => 'text-red-600',
                    4 => 'text-green-600',
                ])
                ->icons([
                    0 => 'shield-check',
                    1 => 'plus',
                    2 => '',
                    3 => '',
                    4 => '',
                ])
                ->labels(Status::list())
                ->sortable(),
            
            Select::make(__('Status'), 'status')
                ->rules('required')
                ->options(Status::list())
                ->default(Status::Active)
                ->onlyOnForms(),
        ];
    }
}
