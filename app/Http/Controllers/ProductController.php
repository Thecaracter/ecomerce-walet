<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Capture search term and active status from query string
        $search = $request->input('search');
        $isActive = $request->input('is_active');

        // Build query with Query Builder
        $query = DB::table('product');

        // Add search condition if exists
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('price', 'like', '%' . $search . '%')
                    ->orWhere('stock', 'like', '%' . $search . '%');
            });
        }

        // Add active status condition if exists
        if ($isActive !== null) {
            $query->where('is_active', $isActive);
        }

        // Get paginated results
        $products = $query->paginate(10)->appends(['search' => $search, 'is_active' => $isActive]);

        return view('admin.product', compact('products', 'search', 'isActive'));
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
        try {
            // Validate the incoming request
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => 'required|boolean',
            ]);

            // Prepare data for saving
            $data = $request->only(['name', 'description', 'price', 'stock', 'is_active']);

            // Handle file upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                // Generate a unique file name with date and time
                $timestamp = Carbon::now()->format('Ymd_His');
                $fileName = $timestamp . '_' . Str::random(10) . '.' . $file->extension();
                $file->move(public_path('foto/product'), $fileName); // Save file to 'public/foto/product'
                $data['foto'] = $fileName; // Store the file name in the database
            }

            // Create a new product
            Product::create($data);

            // Redirect with success message
            return redirect()->route('product.index')->with('success', 'Product created successfully.');

        } catch (\Exception $e) {

            dd($e->getMessage());
            dd($request->all());
            // Log the exception message
            Log::error('Error creating product: ' . $e->getMessage());

            // Redirect with error message
            return redirect()->route('product.index')->with('error', 'Failed to create product. Please try again.');
        }
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
        ]);

        $product = Product::findOrFail($id);

        // Update other fields
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->is_active = $request->input('is_active');

        if ($request->hasFile('foto')) {
            // Delete the old file if it exists
            if ($product->foto) {
                $oldFilePath = public_path('foto/product/' . $product->foto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Handle file upload
            $file = $request->file('foto');
            $timestamp = now()->format('YmdHis'); // Current date and time for unique filename
            $filename = $timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto/product'), $filename);
            $product->foto = $filename; // Store only the filename
        }

        $product->save();

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the product by ID
            $product = Product::findOrFail($id);

            // Check if the product has a photo and delete it from the server
            if ($product->foto && file_exists(public_path('foto/product/' . $product->foto))) {
                unlink(public_path('foto/product/' . $product->foto));
            }

            // Delete the product record from the database
            $product->delete();

            // Redirect with success message
            return redirect()->route('product.index')->with('success', 'Product deleted successfully.');

        } catch (\Exception $e) {
            // Log the exception message
            Log::error('Error deleting product: ' . $e->getMessage());

            // Redirect with error message
            return redirect()->route('product.index')->with('error', 'Failed to delete product. Please try again.');
        }
    }
}
