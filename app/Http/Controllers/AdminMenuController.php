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
        return view('admin.menu', [
            'title' => 'Menu Management',
            'menus' => Menu::orderBy('name')->paginate(8),
            'types' => MenuType::toSelectOption(),
        ]);
    }

    public function register(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email:dns|unique:users',
                'password' => 'required|min:8|max:255|confirmed'
            ];
    
            $input = validator($request->all(), $rules)->validated();
            $input['password'] = Hash::make($input['password']);
            $input['is_admin'] = true;
    
            User::create($input);
    
            return redirect('/login')->with('success', 'Registration successful! Please login.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended('/admin/menus');
            }

            Auth::logout();
        }

        return back()->with('error', 'Login failed!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function profile()
    {

    }
}
