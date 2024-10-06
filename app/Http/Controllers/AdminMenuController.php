<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Enums\MenuType;

class AdminMenuController extends Controller
{
    public function index()
    {
        return view('admin.menu.index', [
            'title' => 'Menu Management',
            'menus' => Menu::orderBy('name')->paginate(8),
            'types' => MenuType::toSelectOption(),
        ]);
    }

    public function edit(string $id)
    {
        $title = 'Menu Management';
        $menu = Menu::findOrFail($id);
        $types = MenuType::toSelectOption();
        return view('admin.menu.edit', compact('title', 'menu', 'types'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required|string',
            'price' => 'required|numeric|min:500',
            'image' => 'image|file|max:2048',
            'tag' => 'required|string',
            'enable' => 'nullable'
        ]);

        //integrate firebase
        // if($request->file('image')) {
        //     $validatedData['image'] = $request->file('image')->store('menu-images');
        // }
        $validatedData['enable'] = isset($validatedData['enable']);

        Menu::create($validatedData); 

        return redirect('/admin/menus')->with('success', 'New Menu has been added!');
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required|string',
            'price' => 'required|numeric|min:500',
            'image' => 'image|file|max:2048',
            'tag' => 'required|string',
            'enable' => 'nullable'
        ]);

        $validatedData['enable'] = isset($validatedData['enable']);

        Menu::where('id', $menu->id)
                ->update($validatedData);

        return redirect('/admin/menus')->with('success', 'Menu has been updated');
    }

    public function isEnable(string $id)
    {
        $menu = Menu::findOrFail($id);
        
        if($menu->enable){
            $menu->enable = false;
        } else {
            $menu->enable = true;
        }
        $menu->save();
        return redirect('/admin/menus')->with('success', 'Menu has been updated');
    }

    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);

        // if($menu->image) {
        //     Storage::delete($menu->image);
        // }

        $menu->delete();
        return redirect('/admin/menus')->with('success', 'Menu has been deleted!');
    }
}
