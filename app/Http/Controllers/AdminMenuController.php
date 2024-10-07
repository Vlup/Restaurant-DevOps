<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Menu;
use App\Enums\MenuType;
use Illuminate\Http\Request;
use Kreait\Firebase\Storage\Bucket;

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
            'image' => 'image|file',
            'tag' => 'required|string',
            'enable' => 'nullable'
        ]);

        $file = $request->file('image');
        $image = $this->uploadFile($file);

        $validatedData['image_url'] = $image['url'];
        $validatedData['image_path'] = $image['path'];
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
            'enable' => 'nullable',
            'image_path' => 'nullable|string',
        ]);

        if ($request->file('image')) {
            if (isset($validatedData['old_image'])) {
                $this->deleteFile();
            }
            $image = $this->uploadFile($request->file('image'));
            $validatedData['image_path'] = $image['path'];
            $validatedData['image_url'] = $image['url'];
        }
        
        unset($validatedData['image']);
        $validatedData['enable'] = isset($validatedData['enable']);

        Menu::where('id', $id)
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

        if($menu->image_path) {
            $this->deleteFile($menu->image_path);
        }

        $menu->delete();
        return redirect('/admin/menus')->with('success', 'Menu has been deleted!');
    }

    public function uploadFile($file)
    {
        $firebase = app('firebase.storage');
        $storage = $firebase->getBucket();

        $storagePath = 'new_food/';
        $filename = now()->setTimezone('Asia/Jakarta')->format('Y-m-d-H:i:s') . '-' . $file->getClientOriginalName();

        $upload = $storage->upload(
            fopen($file->getRealPath(), 'r'),
            [
                'predefinedAcl' => 'publicRead',
                'name' => $storagePath . $filename,
            ]
        );

        return [
            'path' => $storagePath . '' . $filename, 
            'url' => $upload->info()['mediaLink']
        ];
    }

    public function deleteFile($filePath)
    {
        $firebase = app('firebase.storage');
        $storage = $firebase->getBucket();

        $image = $storage->object($filePath);
        $image->delete();
    }
}