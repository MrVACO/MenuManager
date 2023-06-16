<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use MrVaco\SomeHelperCode\Enums\Status;

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
            //'status'      => $this->status->trans(),
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
            return $value['status'] == Status::Active;
        });
        
        return empty($filtered->all()) ? null : MenuResource::collection($filtered->all());
    }
}
