<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MrVaco\SomeHelperCode\Enums\LinkTarget;
use MrVaco\SomeHelperCode\Enums\Status;

class Menu extends Model
{
    protected $table = 'mrvaco_menus';
    
    protected $fillable = [
        'parent_id',
        'title',
        'description',
        'slug',
        'link_target',
        'status',
    ];
    
    protected $casts = [
        'link_target' => LinkTarget::class,
        'status'      => Status::class,
    ];
    
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
    
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->with('children');
    }
}
