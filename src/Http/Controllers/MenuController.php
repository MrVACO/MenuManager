<?php

declare(strict_types = 1);

namespace MrVaco\MenuManager\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use MrVaco\MenuManager\Models\Menu;
use MrVaco\MenuManager\Resources\MenuResource;
use MrVaco\SomeHelperCode\Classes\AdditionalData;
use MrVaco\SomeHelperCode\Enums\Status;

class MenuController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function single(string $slug)
    {
        $data = Menu::query()
            ->where('slug', $slug)
            ->where('status', Status::Active)
            ->first();
        
        return empty($data)
            ? AdditionalData::response('error', true, null, __('Forbidden'))
            : MenuResource::make($data)->additional(AdditionalData::response('success', true));
    }
}
