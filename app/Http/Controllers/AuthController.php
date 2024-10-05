<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
            $request->session()->regenerate();
            
            return redirect()->intended('/');
        }

        return back()->with('error', 'Login failed!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
