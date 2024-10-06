<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Basket;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateBasketRequest;
use Illuminate\Contracts\Support\ValidatedData;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Basket';
        $baskets = User::with('menus')->where('id', Auth::user()->id)->first();
        $hasMenu = $baskets->menus->isNotEmpty();

        return view ('basket.index', compact('title', 'baskets', 'hasMenu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'menu_id' => 'required',
            'qty' => 'required|numeric|min:1',
        ];

        $user = Auth::user();
        $validatedData = $request->validate($rules);
        $menu = Menu::where('id', $validatedData['menu_id'])->first();
        
        $hasOrder = $user->menus()->where('menu_id', $menu->id)->first();
        if($hasOrder == NULL) {
            $user->menus()->attach($menu, ['qty' => $validatedData['qty']]);
        } else {
            $user->menus()->updateExistingPivot($menu->id, ['qty' => $validatedData['qty'] + $hasOrder->basket->qty]);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan menu ke keranjang!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {   
        $validatedData = $request->validate([
            'qty' => 'required|numeric|min:1',
        ]);
        $user = Auth::user();

        $menu = Menu::findOrFail($id);
        $user->menus()->updateExistingPivot($menu->id, ['qty' => $validatedData['qty']]);
        return redirect()->back()->with('success', 'Menu Updated!'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(): RedirectResponse
    {
        $user = Auth::user();
        $user->menus()->detach();
        return redirect()->back()->with('success', 'Basket Cleared!'); 
    }

    public function detach(string $id): RedirectResponse
    {
        $user = Auth::user();
        $menu = Menu::findOrFail($id);

        $menu->users()->detach($user);

        return redirect()->back()->with('success', 'Menu Deleted!'); 
    }
}
