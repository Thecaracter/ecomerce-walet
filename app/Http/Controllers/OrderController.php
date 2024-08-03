<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $status = $request->input('status', 'pembayaran');

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

        return view('admin.order', [
            'orders' => $orders,
            'search' => $search,
            'currentStatus' => $status,
        ]);
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pengiriman,ditolak,diterima',
        ]);

        try {
            $order = Order::findOrFail($id);

            $newStatus = $request->input('status');
            $order->status = $newStatus;
            $order->save();

            if ($newStatus === 'pengiriman') {
                return redirect()->back()->with('success', "Order status updated to pengiriman successfully.");

            } elseif ($newStatus === 'ditolak') {
                return redirect()->back()->with('success', "Order status updated to ditolak successfully.");
            } elseif ($newStatus === 'diterima') {
                return redirect()->back()->with('success', "Order status updated to diterima successfully.");
            }

        } catch (\Exception $e) {
            \Log::error('Error updating order status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the order status. Please try again.');
        }
    }


}
