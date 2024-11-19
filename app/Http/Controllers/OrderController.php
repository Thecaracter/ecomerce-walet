<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        // Default status array berisi 'pembayaran' dan 'proses'
        $status = $request->input('status', ['pembayaran', 'proses', 'pengiriman']);

        $orders = Order::with('user', 'orderDetails.product')
            ->whereIn('status', (array) $status) // Menggunakan whereIn untuk multiple status
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
        try {
            $order = Order::findOrFail($id);
            $currentStatus = $order->status;
            $newStatus = $request->input('status');

            // Validasi perpindahan status
            if ($currentStatus === 'proses' && $newStatus === 'pengiriman') {
                // Validasi resi code saat update dari proses ke pengiriman
                $request->validate([
                    'status' => 'required|in:pengiriman',
                    'resi_code' => 'required|string|min:5'
                ]);

                $order->status = $newStatus;
                $order->resi_code = $request->input('resi_code');
                $order->save();

                return redirect()->back()
                    ->with('success', 'Order status updated to pengiriman with resi code: ' . $order->resi_code);
            }
            // Validasi untuk status lainnya
            else {
                $request->validate([
                    'status' => 'required|in:proses,ditolak,diterima'
                ]);

                // Validasi alur status
                $allowedTransitions = [
                    'pembayaran' => ['proses', 'ditolak'],
                    'proses' => ['pengiriman', 'ditolak'],
                    'pengiriman' => ['diterima'],
                ];

                if (
                    !isset($allowedTransitions[$currentStatus]) ||
                    !in_array($newStatus, $allowedTransitions[$currentStatus])
                ) {
                    return redirect()->back()
                        ->with('error', 'Invalid status transition');
                }

                $order->status = $newStatus;
                $order->save();

                $messages = [
                    'proses' => 'Order status updated to proses successfully.',
                    'ditolak' => 'Order status updated to ditolak successfully.',
                    'diterima' => 'Order status updated to diterima successfully.'
                ];

                return redirect()->back()->with('success', $messages[$newStatus]);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error updating order status: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while updating the order status. Please try again.')
                ->withInput();
        }
    }
}