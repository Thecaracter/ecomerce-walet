<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil 3 produk teratas berdasarkan jumlah penjualan
        $topSellingProducts = Product::withSum('orderDetails as total_sales', 'qty')
            ->orderBy('total_sales', 'desc')
            ->take(3)
            ->get();
        $totalSoldQuantity = OrderDetail::sum('qty');
        $productCount = Product::count();
        $userCount = User::count();
        return view('user.home', compact('topSellingProducts', 'productCount', 'userCount', 'totalSoldQuantity'));
    }
}
