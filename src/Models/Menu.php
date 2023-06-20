<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MrVaco\SomeHelperCode\Enums\LinkTarget;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Menu extends Model implements Sortable
{
    use SortableTrait;
    
    protected $table = 'mrvaco_menus';
    
    protected $fillable = [
        'parent_id',
        'title',
        'description',
        'slug',
        'link_target',
        'status',
        'sort_order',
    ];
    
    protected $casts = [
        'link_target' => LinkTarget::class,
    ];
    
    public array $sortable = [
        'order_column_name'  => 'sort_order',
        'sort_when_creating' => true,
        'sort_on_has_many'   => true,
    ];
    
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with('children')
            ->orderBy('sort_order');
    }
}
