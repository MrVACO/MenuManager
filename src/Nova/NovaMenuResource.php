<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;
use MrVaco\MenuManager\Filters\FilterByLinkTarget;
use MrVaco\MenuManager\Filters\FilterByStatus;
use MrVaco\MenuManager\Models\Menu;
use MrVaco\NovaStatusesManager\Classes\StatusClass;
use MrVaco\NovaStatusesManager\Fields\Status;
use MrVaco\SomeHelperCode\Enums\LinkTarget;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class NovaMenuResource extends Resource
{
    use HasSortableRows;
    
    public static function uriKey(): string
    {
        return 'menu';
    }
    
    public static function label(): string
    {
        return __('Menu');
    }
    
    public static $displayInNavigation = false;
    
    public static string $model = Menu::class;
    
    public static $title = 'title';
    
    public static $search = [
        'title'
    ];
    
    const DEFAULT_INDEX_ORDER = 'sort_order';
    
    public function fields(Request $request): array
    {
        return [
            ID::make()->sortable(),
            
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
            
            Panel::make('secondary', $this->secondaryPanel()),
            
            HasMany::make(__('Child elements'), 'children', self::class)->sortable(),
        ];
    }
    
    protected function secondaryPanel(): array
    {
        return [
            BelongsTo::make(__('Parent item'), 'parent', self::class)
                ->sortable()
                ->nullable()
                ->col(),
            
            Select::make(__('Link target'), 'link_target')
                ->rules('required')
                ->options(LinkTarget::list())
                ->default(LinkTarget::Self)
                ->onlyOnForms()
                ->col(),
            
            Status::make(__('Status'), 'status')
                ->rules('required')
                ->options(StatusClass::LIST('full'))
                ->default(StatusClass::ACTIVE()->id)
                ->sortable()
                ->col(),
        ];
    }
    
    public static function indexQuery($request, $query)
    {
        $query->when(empty($request->get('orderBy')), function(Builder $q)
        {
            $q->getQuery()->orders = [];
            
            return $q->orderBy(static::DEFAULT_INDEX_ORDER);
        });
    }
    
    public function filters(NovaRequest $request): array
    {
        return [
            new FilterByStatus,
            new FilterByLinkTarget
        ];
    }
    
    public static function createButtonLabel(): string
    {
        return __('Create');
    }
    
    public static function updateButtonLabel(): string
    {
        return __('Update');
    }
}
