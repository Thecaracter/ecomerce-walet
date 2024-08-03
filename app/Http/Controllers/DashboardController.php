<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = Order::whereIn('status', ['proses', 'pengiriman', 'diterima'])->count();
        $orderSuccessCount = Order::where('status', 'diterima')->count();

        // Calculate the total revenue for the current month
        $monthlyRevenue = Order::where('status', 'diterima')
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->sum('total_price');

        // Calculate the total revenue for the previous month
        $currentMonth = date('m');
        $currentYear = date('Y');
        $previousMonth = $currentMonth - 1;
        $previousYear = $currentYear;

        // Adjust for the start of the year
        if ($previousMonth < 1) {
            $previousMonth = 12;
            $previousYear--;
        }

        $previousMonthRevenue = Order::where('status', 'diterima')
            ->whereYear('created_at', $previousYear)
            ->whereMonth('created_at', $previousMonth)
            ->sum('total_price');

        // Calculate the percentage change
        if ($previousMonthRevenue > 0) {
            $percentageChange = (($monthlyRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100;
        } else {
            $percentageChange = $monthlyRevenue > 0 ? 100 : 0;
        }

        // Format the percentage change
        $percentageChangeFormatted = number_format($percentageChange, 0, ',', '.');

        // Retrieve order success statistics per month for the current year
        $orderSuccessStatistics = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', 'diterima')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->all();

        // Fill missing months with zero
        $orderSuccessStatistics = array_replace(array_fill(1, 12, 0), $orderSuccessStatistics);

        return view(
            'admin.dashboard',
            compact(
                'userCount',
                'productCount',
                'orderCount',
                'orderSuccessCount',
                'monthlyRevenue',
                'previousMonthRevenue',
                'percentageChangeFormatted',
                'orderSuccessStatistics'
            )
        );
    }
    public function topSellingProducts()
    {
        // Get the top-selling products by quantity
        $topSellingProducts = \DB::table('order_detail')
            ->join('order', 'order_detail.order_id', '=', 'order.id')
            ->join('product', 'order_detail.product_id', '=', 'product.id')
            ->select('product.id as product_id', 'product.name', 'product.foto', \DB::raw('SUM(order_detail.qty) as total_qty'))
            ->where('order.status', 'diterima')
            ->groupBy('product.id', 'product.name', 'product.foto')
            ->orderBy('total_qty', 'desc')
            ->limit(5) // Adjust the limit as needed
            ->get();

        return response()->json($topSellingProducts);
    }


}
