<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
        
        // Configure Midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('orderItems.kuliner')
            ->latest()
            ->get();
        return view('orders.index', compact('orders'));
    }

    public function place(Request $request)
    {
        try {
            DB::beginTransaction();

            // Get cart items
            $cartItems = Cart::withoutGlobalScopes()
                ->where('user_id', Auth::id())
                ->where('is_checked_out', false)
                ->with('kuliner')
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Keranjang belanja kosong');
            }

            // Calculate total
            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->kuliner->harga;
            });

            // Generate order_id first
            $orderId = 'ORDER-' . time() . '-' . Auth::id();

            // Create order with order_id
            $order = Order::create([
                'order_id' => $orderId,
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => Order::STATUS_PENDING,
                'payment_status' => Order::PAYMENT_PENDING
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                if ($item->kuliner->stok < $item->quantity) {
                    throw new \Exception("Stok {$item->kuliner->nama} tidak mencukupi");
                }

                $order->orderItems()->create([
                    'kuliner_id' => $item->kuliner_id,
                    'quantity' => $item->quantity,
                    'price' => $item->kuliner->harga
                ]);

                // Update stock
                $item->kuliner->decrement('stok', $item->quantity);
            }

            // Get Midtrans payment info
            $paymentInfo = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $total
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'billing_address' => [
                        'address' => Auth::user()->alamat ?? '-'
                    ]
                ],
                'item_details' => $cartItems->map(function ($item) {
                    return [
                        'id' => $item->kuliner_id,
                        'price' => (int) $item->kuliner->harga,
                        'quantity' => $item->quantity,
                        'name' => $item->kuliner->nama
                    ];
                })->toArray()
            ];

            // Create Midtrans transaction
            $snapToken = \Midtrans\Snap::getSnapToken($paymentInfo);
            $order->snap_token = $snapToken;
            $order->save();

            // Mark cart items as checked out
            $cartItems->each(function ($item) {
                $item->update(['is_checked_out' => true]);
            });

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $order->load('orderItems.kuliner', 'user');
        return view('orders.show', compact('order'));
    }

    public function notification(Request $request)
    {
        try {
            $notification = new \Midtrans\Notification();
            
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            $order = Order::where('order_id', $orderId)->firstOrFail();

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $order->payment_status = Order::PAYMENT_PENDING;
                } else if ($fraudStatus == 'accept') {
                    $order->markAsPaid();
                }
            } else if ($transactionStatus == 'settlement') {
                $order->markAsPaid();
            } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->payment_status = Order::PAYMENT_FAILED;
                $order->status = Order::STATUS_CANCELLED;
                $order->save();

                // Return stock
                foreach ($order->orderItems as $item) {
                    $item->kuliner->increment('stok', $item->quantity);
                }
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function adminIndex()
    {
        $orders = Order::with(['user', 'orderItems.kuliner'])
            ->latest()
            ->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
}