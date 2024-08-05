<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = $request->only('id', 'name', 'price', 'foto', 'berat'); // Include 'berat'
        $cart = session()->get('cart', []);

        // Check if the product is already in the cart
        if (isset($cart[$product['id']])) {
            $cart[$product['id']]['quantity']++;
        } else {
            $product['quantity'] = 1;
            $cart[$product['id']] = $product;
        }

        session()->put('cart', $cart);

        return response()->json(['success' => 'Product added to cart successfully!']);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('user.keranjang', compact('cart'));
    }

    public function updateQuantity(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('id');
        $quantity = $request->input('quantity');

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + $item['price'] * $item['quantity'];
        }, 0);

        $totalWeight = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['berat'] ?? 0) * $item['quantity'];
        }, 0);

        return response()->json([
            'cart' => $cart,
            'total' => $total,
            'total_weight' => $totalWeight
        ]);
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('id');

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + $item['price'] * $item['quantity'];
        }, 0);

        $totalWeight = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['berat'] ?? 0) * $item['quantity'];
        }, 0);

        return response()->json([
            'cart' => $cart,
            'total' => $total,
            'total_weight' => $totalWeight
        ]);
    }
    public function checkout()
    {
        $cart = session()->get('cart', []);
        session()->put('checkout_cart', $cart); // Simpan data keranjang ke session

        return redirect()->route('ongkir');
    }
}
