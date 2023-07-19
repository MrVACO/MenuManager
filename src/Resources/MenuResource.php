<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use MrVaco\NovaStatusesManager\Classes\StatusClass;

/** @mixin \MrVaco\MenuManager\Models\Menu */
class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'slug'        => $this->slug,
            'link_target' => $this->link_target,
            'children'    => $this->getChildren(),
        ];
    }
    
    protected function getChildren(): ?AnonymousResourceCollection
    {
        $collection = $this->children;
        
        $filtered = $collection->filter(function($value, $key)
        {
            return $value['status'] == StatusClass::ACTIVE()->id;
        });
        
        return empty($filtered->all()) ? null : MenuResource::collection($filtered->all());
    }
}
