<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderUserController extends Controller
{
    public function index()
    {
        $title = 'Pesanan';
        $orders = Order::with('menus')->where('user_id', Auth::user()->id)->get();
        return view('order.index', compact('title', 'orders'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'total' => 'required|numeric|min:500',
        ]);
        
        $user = Auth::user();
        $validatedData['status'] = 'pending';
    
        DB::beginTransaction();
        try {
            $order = new Order();
            $order->id = (string) Str::uuid();
            $orderId = $order->id;
            $order->total = $validatedData['total'];
            $order->user_id = $user->id;
            $order->save();

            foreach ($request->menus as $index => $menuId) {
                $menuData = ['menu_id' => $menuId, 'order_id' => $orderId, 'qty' => $request->qty[$index]];
                OrderDetail::create($menuData);
            }

            $user->menus()->detach();
        
            DB::commit();
            return redirect()->back()->with('success', 'Order has been made!');
        } catch(\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create the order!');
        }
    }
}
