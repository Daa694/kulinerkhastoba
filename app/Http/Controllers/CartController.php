<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Kuliner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $items = Cart::getUserCart(Auth::id());
            $total = Cart::getCartTotal(Auth::id());

            return view('cart.index', compact('items', 'total'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memuat keranjang: ' . $e->getMessage());
        }
    }

    public function add(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'kuliner_id' => 'required|exists:kuliners,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $kuliner = Kuliner::findOrFail($validated['kuliner_id']);
            if (!$kuliner->tersedia) {
                throw new \Exception('Maaf, menu ini sedang tidak tersedia');
            }

            if ($kuliner->stok < $validated['quantity']) {
                throw new \Exception("Stok tidak mencukupi. Stok tersedia: {$kuliner->stok}");
            }

            $cart = Cart::withoutGlobalScopes()
                       ->where('user_id', Auth::id())
                       ->where('kuliner_id', $validated['kuliner_id'])
                       ->where('is_checked_out', false)
                       ->first();

            if ($cart) {
                $newQuantity = $cart->quantity + $validated['quantity'];
                if ($newQuantity > $kuliner->stok) {
                    throw new \Exception('Stok tidak mencukupi');
                }
                $cart->quantity = $newQuantity;
                $cart->save();
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'kuliner_id' => $validated['kuliner_id'],
                    'quantity' => $validated['quantity'],
                    'is_checked_out' => false
                ]);
            }
            
            DB::commit();
            return redirect()->route('cart.index')->with('success', 'Berhasil ditambahkan ke keranjang');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'cart_id' => 'required|exists:carts,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = Cart::withoutGlobalScopes()
                ->where('id', $validated['cart_id'])
                ->where('user_id', Auth::id())
                ->where('is_checked_out', false)
                ->firstOrFail();

            // Check if we have enough stock
            if ($cart->kuliner->stok < $validated['quantity']) {
                throw new \Exception("Stok tidak mencukupi. Stok tersedia: {$cart->kuliner->stok}");
            }

            $cart->quantity = $validated['quantity'];
            $cart->save();

            // Calculate new total
            $total = Cart::getCartTotal(Auth::id());

            DB::commit();

            return response()->json([
                'success' => true,
                'total' => $total
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function remove($id)
    {
        try {
            DB::beginTransaction();

            $cart = Cart::withoutGlobalScopes()
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->where('is_checked_out', false)
                ->firstOrFail();

            $cart->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus item: ' . $e->getMessage()
            ], 400);
        }
    }

    public function clear()
    {
        try {
            DB::beginTransaction();

            Cart::withoutGlobalScopes()
                ->where('user_id', Auth::id())
                ->where('is_checked_out', false)
                ->delete();

            DB::commit();
            return redirect()->route('cart.index')
                ->with('success', 'Keranjang berhasil dikosongkan');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal mengosongkan keranjang: ' . $e->getMessage());
        }
    }

    public function ajaxUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'cart_id' => 'required|exists:carts,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cart = Cart::withoutGlobalScopes()
                ->where('id', $validated['cart_id'])
                ->where('user_id', Auth::id())
                ->where('is_checked_out', false)
                ->firstOrFail();

            if ($cart->kuliner->stok < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok {$cart->kuliner->nama} tidak mencukupi"
                ], 400);
            }

            $cart->quantity = $validated['quantity'];
            $cart->save();

            $total = Cart::getCartTotal(Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated',
                'subtotal' => $cart->subtotal,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
