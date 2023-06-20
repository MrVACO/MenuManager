<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;
use MrVaco\NovaStatusesManager\Classes\StatusClass;

class FilterByStatus extends BooleanFilter
{
    public function name(): string
    {
        return __('By Status');
    }
    
    public function default(): array
    {
        return collect($this->options(app(NovaRequest::class)))->values()->mapWithKeys(function($option)
        {
            return [$option => true];
        })->all();
    }
    
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->whereIn('status', array_keys($value, true));
    }
    
    public function options(NovaRequest $request): array
    {
        return StatusClass::LIST('full', true);
    }
}
