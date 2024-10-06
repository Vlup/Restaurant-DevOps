<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function index()
    {
        $title = 'Admin Management';
        $admins = User::select('name', 'email')
            ->where('is_admin', true)
            ->orderBy('name')
            ->paginate(8);
            
        return view('admin.admin', compact('title', 'admins'));
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
    
            return redirect()->back()->with('success', 'Registration successful!');
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
