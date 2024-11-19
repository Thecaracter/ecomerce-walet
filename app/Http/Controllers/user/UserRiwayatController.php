<?php

namespace App\Http\Controllers\user;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserRiwayatController extends Controller
{
    public function index()
    {
        $riwayats = Order::where('user_id', Auth::user()->id)
            ->with(['user', 'orderDetails.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.riwayat', compact('riwayats'));
    }

    public function terima(Request $request, $id)
    {
        try {
            $order = Order::where('user_id', Auth::user()->id)
                ->findOrFail($id);

            // Update status pesanan menjadi diterima
            $order->status = 'diterima';
            $order->resi_code = $request->resi_code;
            $order->received_at = now();
            $order->save();

            Log::info('Pesanan berhasil diterima', [
                'order_id' => $id,
                'user_id' => Auth::user()->id,
                'status' => 'diterima',
                'resi_code' => $request->resi_code,
                'received_at' => now()
            ]);

            return redirect()->back()
                ->with('success', 'Pesanan telah diterima');

        } catch (\Exception $e) {
            Log::error('Error saat menerima pesanan', [
                'order_id' => $id,
                'user_id' => Auth::user()->id,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal mengubah status pesanan');
        }
    }
}