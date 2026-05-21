<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_products = Product::count();
        $total_orders = Order::count();
        $total_users = User::where('role', 'customer')->count();
        
        $total_pendapatan = Order::where('status', 'paid')->sum('total_harga');
        $pesanan_baru = Order::where('status', 'pending')->count();
        
        // Relasi dengan user dan orderDetails agar bisa ditampilkan di blade
        $recent_orders = Order::with(['user', 'orderDetails'])->orderBy('id', 'desc')->take(5)->get();

        // Data Penjualan (Grafik 7 Hari Terakhir)
        $sales_data = ['labels' => [], 'data' => []];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $sales = Order::where('status', 'paid')->whereDate('created_at', $date)->sum('total_harga');
            $sales_data['labels'][] = Carbon::parse($date)->format('d M');
            $sales_data['data'][] = $sales;
        }

        return view('admin.dashboard', compact(
            'total_products', 
            'total_orders', 
            'total_users', 
            'total_pendapatan', 
            'pesanan_baru', 
            'recent_orders',
            'sales_data'
        ));
    }
}
