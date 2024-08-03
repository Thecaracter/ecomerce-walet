<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
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

        $orderSuccessStatistics = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', 'diterima')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->all();

        // Fill missing months with zero
        $orderSuccessStatistics = array_replace(array_fill(1, 12, 0), $orderSuccessStatistics);

        return view('admin.dashboard', compact('userCount', 'productCount', 'orderCount', 'orderSuccessCount', 'orderSuccessStatistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
