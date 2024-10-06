<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    public function index() {
        $title = 'Customer Order';
        $orders = Order::orderBy("created_at", "asc")->with('menus', 'user')->get();
        return view('admin.order.index', compact('title', 'orders'));
    }

    public function complete(string $id) {
        $order = Order::findOrFail($id);
        $order->status = OrderStatus::COMPLETED;
        $order->save();

        return redirect()->back()->with('success', 'Order has been completed');
    }

    public function accept(string $id) {
        $order = Order::findOrFail($id);
        $order->status = OrderStatus::ON_GOING;
        $order->save();

        return redirect()->back()->with('success', 'Order has been accepted');
    }

    public function decline(string $id) {
        $order = Order::findOrFail($id);
        $order->status = OrderStatus::DECLINED;
        $order->save();

        return redirect()->back()->with('success', 'Order has been declined');
    }
}
