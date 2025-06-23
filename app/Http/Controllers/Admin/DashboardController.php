<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kuliner;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }    public function index()
    {
        try {
            // Get recent orders with user information
            $recentOrders = Order::with(['user'])
                                ->orderBy('created_at', 'desc')
                                ->take(10)
                                ->get();

            $data = [
                'totalKuliners' => $this->getTotalKuliners(),
                'totalOrders' => $this->getTotalOrders(),
                'totalUsers' => $this->getTotalUsers(),
                'popularKuliners' => $this->getPopularKuliners(),
                'recentOrders' => $recentOrders,
                'monthlySales' => $this->getMonthlySales()
            ];

            return view('admin.dashboard', $data);
        } catch (\Exception $e) {
            return back()->with('error', 'Error loading dashboard: ' . $e->getMessage());
        }
    }

    protected function getTotalKuliners()
    {
        return DB::table('kuliners')->count();
    }

    protected function getTotalOrders()
    {
        return DB::table('orders')->count();
    }

    protected function getTotalUsers()
    {
        return DB::table('users')->where('role', 'user')->count();
    }    protected function getPopularKuliners()
    {
        return DB::table('kuliners')
            ->leftJoin('ratings', 'kuliners.id', '=', 'ratings.kuliner_id')
            ->select(
                'kuliners.id',
                'kuliners.nama',
                'kuliners.deskripsi',
                'kuliners.harga',
                'kuliners.gambar',
                'kuliners.stok',
                'kuliners.tersedia',
                'kuliners.created_at',
                'kuliners.updated_at',
                DB::raw('AVG(ratings.rating) as ratings_avg_rating'),
                DB::raw('COUNT(ratings.id) as ratings_count')
            )
            ->groupBy(
                'kuliners.id',
                'kuliners.nama',
                'kuliners.deskripsi',
                'kuliners.harga',
                'kuliners.gambar',
                'kuliners.stok',
                'kuliners.tersedia',
                'kuliners.created_at',
                'kuliners.updated_at'
            )
            ->orderByDesc('ratings_avg_rating')
            ->limit(5)
            ->get();
    }

    protected function getRecentOrders()
    {
        return Order::with('user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
    }
    protected function getMonthlySales()
    {
        $monthlySales = DB::table('orders')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_sales'),
                DB::raw('COUNT(*) as total_orders')
            )
            ->where('payment_status', 'settlement')
            ->orWhere('payment_status', 'capture')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function ($item) {
                $monthName = date('F', mktime(0, 0, 0, $item->month, 1));
                return [
                    'period' => $monthName . ' ' . $item->year,
                    'total_sales' => $item->total_sales,
                    'total_orders' => $item->total_orders,
                    'average_order' => $item->total_orders > 0 ? $item->total_sales / $item->total_orders : 0
                ];
            });

        return $monthlySales;
    }

}
