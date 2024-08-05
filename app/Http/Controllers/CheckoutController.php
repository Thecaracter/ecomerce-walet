<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function storeOrder(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Generate the order number
        $lastOrder = Order::orderBy('id', 'desc')->first();
        $orderNumber = 'ORDwal-' . ($lastOrder ? $lastOrder->id + 1 : 1);

        // Start a transaction
        DB::beginTransaction();

        try {
            // Create the order
            $order = new Order();
            $order->order_number = $orderNumber;
            $order->user_id = $user->id;
            $order->total_price = $request->input('total_price');
            $order->total_weight = $request->input('total_weight'); // Add this line
            $order->status = 'pembayaran'; // Default status
            $order->alamat_pengiriman = $request->input('alamat_pengiriman');
            $order->pengiriman = $request->input('pengiriman');
            $order->save();

            // Create order details
            foreach ($request->input('order_details') as $detail) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $detail['product_id'];
                $orderDetail->qty = $detail['qty'];
                $orderDetail->price = $detail['price'];
                $orderDetail->save();
            }

            // Commit the transaction
            DB::commit();

            // Clear the cart session
            $request->session()->forget('cart');

            return response()->json(['success' => 'Order placed successfully!', 'order_number' => $orderNumber]);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return response()->json(['error' => 'Failed to place order!', 'exception' => $e->getMessage()], 500);
        }
    }
}
