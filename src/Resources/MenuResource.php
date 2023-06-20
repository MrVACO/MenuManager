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
            //'id'          => $this->id,
            //'parent_id'   => $this->parent_id,
            'title'       => $this->title,
            'description' => $this->description,
            'slug'        => $this->slug,
            'link_target' => $this->link_target,
            //'status'      => $this->status,
            //'sort_order'  => $this->sort_order,
            //'created_at'  => $this->created_at,
            //'updated_at'  => $this->updated_at,
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
