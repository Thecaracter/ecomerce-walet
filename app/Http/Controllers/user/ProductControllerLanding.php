<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductControllerLanding extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('user.product', compact('products'));
    }
}
