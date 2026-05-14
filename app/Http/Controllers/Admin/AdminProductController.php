<?php
// app/Http/Controllers/Admin/AdminProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    // List all products
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->filled('search')) {
            $query->where('name','like','%'.$request->search.'%')
                  ->orWhere('brand','like','%'.$request->search.'%');
        }
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        $products   = $query->latest()->paginate(15)->withQueryString();
        $categories = Product::distinct()->pluck('category')->sort()->values();
        return view('admin.products.index', compact('products','categories'));
    }

    // Show create form
    public function create()
    {
        $categories = Product::distinct()->pluck('category')->sort()->values();
        return view('admin.products.create', compact('categories'));
    }

    // Store new product
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => ['required','string','max:255'],
            'description'    => ['nullable','string'],
            'category'       => ['required','string'],
            'brand'          => ['nullable','string'],
            'price'          => ['required','numeric','min:0'],
            'original_price' => ['nullable','numeric','min:0'],
            'discount'       => ['nullable','integer','min:0','max:100'],
            'stock'          => ['required','integer','min:0'],
            'rating'         => ['nullable','numeric','min:0','max:5'],
            'reviews_count'  => ['nullable','integer','min:0'],
            'is_prime'       => ['boolean'],
            'is_featured'    => ['boolean'],
            'image'          => ['nullable','string'],
        ]);

        $data['is_prime']    = $request->boolean('is_prime');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['discount']    = $data['discount'] ?? 0;

        // Handle image upload
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time().'_'.str_replace(' ','-',$file->getClientOriginalName());
            $file->move(public_path('images/products'), $filename);
            $data['image'] = 'images/products/'.$filename;
        }

        Product::create($data);
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product added successfully!');
    }

    // Show edit form
    public function edit(Product $product)
    {
        $categories = Product::distinct()->pluck('category')->sort()->values();
        return view('admin.products.edit', compact('product','categories'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'           => ['required','string','max:255'],
            'description'    => ['nullable','string'],
            'category'       => ['required','string'],
            'brand'          => ['nullable','string'],
            'price'          => ['required','numeric','min:0'],
            'original_price' => ['nullable','numeric','min:0'],
            'discount'       => ['nullable','integer','min:0','max:100'],
            'stock'          => ['required','integer','min:0'],
            'rating'         => ['nullable','numeric','min:0','max:5'],
            'reviews_count'  => ['nullable','integer','min:0'],
            'is_prime'       => ['boolean'],
            'is_featured'    => ['boolean'],
            'image'          => ['nullable','string'],
        ]);

        $data['is_prime']    = $request->boolean('is_prime');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['discount']    = $data['discount'] ?? 0;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time().'_'.str_replace(' ','-',$file->getClientOriginalName());
            $file->move(public_path('images/products'), $filename);
            $data['image'] = 'images/products/'.$filename;
        }

        $product->update($data);
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully!');
    }
}