<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.kuliner'])
                      ->orderBy('created_at', 'desc')
                      ->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diantar,sukses,batal'
        ]);

        $order->status = $request->status;
        
        // Jika status berubah menjadi sukses, update juga payment_status
        if ($request->status === 'sukses') {
            $order->payment_status = 'sukses';
        }
        
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.kuliner']);
        return view('admin.orders.show', compact('order'));
    }
}
