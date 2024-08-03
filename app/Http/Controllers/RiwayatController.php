<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $status = $request->input('status', 'diterima');

        $orders = Order::with('user', 'orderDetails.product')  // Eager load 'product' with 'orderDetails'
            ->where('status', $status)
            ->where(function ($query) use ($search) {
                $query->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            })
            ->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->appends(['search' => $search, 'status' => $status]);

        return view('admin.riwayat', [
            'orders' => $orders,
            'search' => $search,
            'currentStatus' => $status,
        ]);
    }
}
