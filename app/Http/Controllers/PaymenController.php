<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PaymenController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index(Request $request)
    {
        $orderNumber = $request->input('order_number');

        if (!$orderNumber) {
            return redirect()->route('home')->with('error', 'Order number is required');
        }

        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found');
        }

        // Generate Snap token
        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone,
                'shipping_address' => [
                    'address' => $order->alamat_pengiriman,
                ]
            ],
        ]);

        return view('user.payment', [
            'order' => $order,
            'snapToken' => $snapToken,
        ]);
    }

    public function paymentCallback(Request $request)
    {
        Log::info('Payment Callback Hit', $request->all());

        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            Log::info('Signature key matched.');

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                // Update order status to "proses"
                $order = Order::where('order_number', $request->order_id)->first();

                if ($order) {
                    $order->status = 'proses';
                    $order->save();
                    Log::info('Order status updated to "proses"', ['order_id' => $request->order_id]);

                    // Return success response
                    return response()->json(['success' => true, 'redirect_url' => route('cart')]);
                } else {
                    Log::warning('Order not found', ['order_id' => $request->order_id]);
                }
            } else {
                Log::info('Transaction status is not capture or settlement', ['status' => $request->transaction_status]);
            }
        } else {
            Log::warning('Signature key does not match', ['provided' => $request->signature_key, 'expected' => $hashed]);
        }

        return response()->json(['success' => false]);
    }
    public function updateStatusToProses(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'order_number' => 'required|exists:order,order_number', // Perbaiki nama tabel jika perlu
            ]);

            // Cari pesanan berdasarkan nomor pesanan
            $order = Order::where('order_number', $request->order_number)->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ]);
            }

            // Perbarui status pesanan menjadi "proses"
            $order->status = 'proses';
            $order->save();

            // Beri respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Order status updated to "proses"',
                'redirect_url' => route('home') // Arahkan ke halaman home jika diperlukan
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating order status', [
                'error' => $e->getMessage(),
                'order_number' => $request->order_number
            ]);

            // Beri respons gagal
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status'
            ]);
        }
    }

}
