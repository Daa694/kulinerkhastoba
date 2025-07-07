<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{      public function __construct()
    {
        $this->middleware('auth', ['except' => ['notification', 'finish', 'unfinish', 'error']]);
          // Configure Midtrans
        \Midtrans\Config::$serverKey = 'SB-Mid-server-bl-1QMhrECrMXHPZyyoHbRoe';
        \Midtrans\Config::$isProduction = false;
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
                'gross_amount' => $total, // ensure gross_amount is filled
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
            }            // Get base URL for callbacks
            $baseUrl = url('/');
            
            // Get Midtrans payment info
            $paymentInfo = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $total
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone ?? '',
                    'billing_address' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->phone ?? '',
                        'address' => Auth::user()->alamat ?? '-',
                        'country_code' => 'IDN'
                    ]
                ],
                'callbacks' => [
                    'finish' => route('payment.finish'),
                    'unfinish' => route('payment.unfinish'),
                    'error' => route('payment.error'),
                    'notification' => route('payment.notification')
                ],
                'item_details' => $cartItems->map(function ($item) {
                    return [
                        'id' => $item->kuliner_id,
                        'price' => (int) $item->kuliner->harga,
                        'quantity' => $item->quantity,
                        'name' => substr($item->kuliner->nama, 0, 50), // Midtrans has a 50 char limit
                        'category' => 'Kuliner'
                    ];
                })->toArray(),
                'enabled_payments' => [
                    'credit_card', 'mandiri_clickpay', 'cimb_clicks',
                    'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel', 'permata_va',
                    'bca_va', 'bni_va', 'bri_va', 'other_va', 'gopay', 'indomaret',
                    'danamon_online', 'akulaku', 'shopeepay'
                ],
                'credit_card' => [
                    'secure' => true,
                    'channel' => 'migs',
                    'bank' => 'bca',
                    'save_card' => true
                ]
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

    public function showReceipt($orderId)
    {
        $order = Order::with(['user', 'orderItems.kuliner'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        // Only show receipt for completed payments
        if (!in_array($order->payment_status, ['settlement', 'capture'])) {
            abort(404, 'Struk belum tersedia karena pembayaran belum selesai');
        }

        return view('orders.receipt', compact('order'));
    }    public function notification(Request $request)
    {
        try {
            $notification = new \Midtrans\Notification();
            
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;
            $type = $notification->payment_type;
            
            \Log::info('Midtrans Notification:', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'fraud' => $fraudStatus,
                'type' => $type,
                'raw' => $request->all()
            ]);

            $order = Order::where('order_id', $orderId)->firstOrFail();

            // Handle different transaction status
            switch ($transactionStatus) {
                case 'capture':
                    if ($fraudStatus == 'challenge') {
                        $order->payment_status = Order::PAYMENT_CHALLENGE;
                    } else if ($fraudStatus == 'accept') {
                        $order->payment_status = Order::PAYMENT_CAPTURE;
                        $order->status = Order::STATUS_DIANTAR;
                        // Return receipt URL for successful payment
                        $receiptUrl = route('orders.receipt', ['orderId' => $orderId]);
                    }
                    break;
                    
                case 'settlement':
                    $order->payment_status = Order::PAYMENT_SETTLEMENT;
                    $order->status = Order::STATUS_DIANTAR;
                    // Return receipt URL for successful payment
                    $receiptUrl = route('orders.receipt', ['orderId' => $orderId]);
                    break;
                    
                case 'pending':
                    $order->payment_status = Order::PAYMENT_PENDING;
                    break;
                    
                case 'deny':
                    $order->payment_status = Order::PAYMENT_DENY;
                    break;
                    
                case 'expire':
                    $order->payment_status = Order::PAYMENT_EXPIRE;
                    break;
                    
                case 'cancel':
                    $order->payment_status = Order::PAYMENT_CANCEL;
                    break;
                    
                case 'refund':
                    $order->payment_status = Order::PAYMENT_REFUND;
                    break;
                    
                case 'partial_refund':
                    $order->payment_status = Order::PAYMENT_PARTIAL_REFUND;
                    break;
                    
                case 'chargeback':
                    $order->payment_status = Order::PAYMENT_CHARGEBACK;
                    break;
                    
                case 'partial_chargeback':
                    $order->payment_status = Order::PAYMENT_PARTIAL_CHARGEBACK;
                    break;
                    
                case 'authorize':
                    $order->payment_status = Order::PAYMENT_AUTHORIZE;
                    break;
                    
                default:
                    $order->payment_status = Order::PAYMENT_GAGAL;
            }
            
            $order->save();

            return response()->json([
                'success' => true,
                'receipt_url' => $receiptUrl ?? null
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
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
    }    public function confirmReceived(Order $order)
    {
        // Verify that the order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pesanan ini');
        }

        // Verify that the order status is 'diantar'
        if ($order->status !== Order::STATUS_DIANTAR) {
            return redirect()->back()->with('error', 'Pesanan harus dalam status pengiriman untuk dikonfirmasi');
        }

        // Verify that the payment status is successful
        if ($order->payment_status !== Order::PAYMENT_SETTLEMENT && 
            $order->payment_status !== Order::PAYMENT_CAPTURE) {
            return redirect()->back()->with('error', 'Pembayaran harus selesai sebelum pesanan dapat dikonfirmasi');
        }

        // Update order status to 'sukses'
        $order->status = Order::STATUS_SUKSES;
        $order->save();

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi. Terima kasih telah berbelanja!');
    }    public function finish(Request $request)
    {
        \Log::info('Payment Finish:', $request->all());
        
        $orderId = $request->order_id;
        $order = Order::where('order_id', $orderId)->firstOrFail();
        
        if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
            $order->payment_status = $request->transaction_status;
            $order->status = 'diantar';
            $order->payment_type = $request->payment_type;
            $order->save();
            
            // Return with receipt URL
            return redirect()->route('orders.receipt', ['orderId' => $orderId]);
        }
        
        $order->payment_status = $request->transaction_status;
        $order->payment_type = $request->payment_type;
        $order->save();
        
        return redirect()->route('orders.index')->with('message', 'Pembayaran sedang diproses');
    }

    public function unfinish(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::where('order_id', $orderId)->firstOrFail();
        $order->payment_status = 'pending';
        $order->save();
        
        return response()->json(['success' => true]);
    }

    public function error(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::where('order_id', $orderId)->firstOrFail();
        $order->payment_status = 'gagal';
        $order->save();
        
        return response()->json(['success' => true]);
    }
}