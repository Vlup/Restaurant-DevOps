<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Enums\MenuType;

class MenuController extends Controller
{
    public function index()
    {
        return view('index', [
            'title' => 'Home',
            'menus' => Menu::orderBy('name')->paginate(8),
            'types' => MenuType::toSelectOption(),
        ]);
    }
}
