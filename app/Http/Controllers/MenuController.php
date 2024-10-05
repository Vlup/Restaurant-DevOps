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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required|string',
            'price' => 'required|numeric|min:500',
            'image' => 'image|file|max:2048',
            'tag' => 'required|string'
        ]);

        //integrate firebase
        // if($request->file('image')) {
        //     $validatedData['image'] = $request->file('image')->store('menu-images');
        // }

        $validatedData['enable'] = true;

        Menu::create($validatedData); 

        return redirect('/')->with('success', 'New Menu has been added!');
    }
}
