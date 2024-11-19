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
    public function index(Request $request)
    {
        try {
            Log::info('Product index accessed', [
                'search' => $request->input('search'),
                'is_active' => $request->input('is_active')
            ]);

            $search = $request->input('search');
            $isActive = $request->input('is_active');
            $query = DB::table('product');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('price', 'like', '%' . $search . '%')
                        ->orWhere('berat', 'like', '%' . $search . '%');
                });
            }

            if ($isActive !== null) {
                $query->where('is_active', $isActive);
            }

            $products = $query->paginate(10)->appends(['search' => $search, 'is_active' => $isActive]);

            return view('admin.product', compact('products', 'search', 'isActive'));
        } catch (\Exception $e) {
            Log::error('Error in product index', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data produk.');
        }
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        Log::info('Attempting to create new product', [
            'request_data' => $request->except(['foto']),
            'has_photo' => $request->hasFile('foto')
        ]);

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'berat' => 'required|integer',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => 'required|boolean',
            ]);

            $data = $request->only(['name', 'description', 'price', 'berat', 'is_active']);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $timestamp = Carbon::now()->format('Ymd_His');
                $fileName = $timestamp . '_' . Str::random(10) . '.' . $file->extension();
                $file->move(public_path('foto/product'), $fileName);
                $data['foto'] = $fileName;
            }

            Product::create($data);

            return redirect()->route('product.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating product', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            return redirect()->route('product.index')->with('error', 'Failed to create product. ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Starting product update process', [
            'product_id' => $id,
            'request_data' => $request->all()
        ]);

        try {
            // Validate request
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price_display' => 'required|string',
                'berat' => 'required|integer',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'required|boolean',
            ]);

            // Format price - remove 'Rp ' and '.' then convert to integer
            $price = (int) str_replace(['Rp ', '.'], '', $request->input('price_display'));

            Log::info('Price formatting', [
                'original_price' => $request->input('price_display'),
                'formatted_price' => $price
            ]);

            // Find product
            $product = Product::findOrFail($id);

            // Handle file upload if new photo is provided
            if ($request->hasFile('foto')) {
                Log::info('Processing new photo upload');

                // Delete old photo if exists
                if ($product->foto) {
                    $oldFilePath = public_path('foto/product/' . $product->foto);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                        Log::info('Old photo deleted');
                    }
                }

                // Upload new photo
                $file = $request->file('foto');
                $timestamp = now()->format('YmdHis');
                $filename = $timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('foto/product'), $filename);
                $product->foto = $filename;
            }

            // Update fields
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $price;
            $product->berat = $request->input('berat');
            $product->is_active = $request->input('is_active');

            Log::info('Saving product updates', [
                'changes' => $product->getDirty()
            ]);

            $product->save();

            return redirect()
                ->route('product.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            Log::error('Error updating product', [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return redirect()
                ->route('product.index')
                ->with('error', 'Failed to update product. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->foto && file_exists(public_path('foto/product/' . $product->foto))) {
                unlink(public_path('foto/product/' . $product->foto));
            }

            $product->delete();

            return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return redirect()->route('product.index')->with('error', 'Failed to delete product. Please try again.');
        }
    }
}