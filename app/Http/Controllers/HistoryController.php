<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index() {
        $title = 'History';
        $orders = Order::latest()->with('menus')->where('user_id', Auth::user()->id)->get();
        return view('history.index', compact('title', 'orders'));
    }
}
