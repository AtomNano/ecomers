<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductTierPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('stock', '>', 0);
            } elseif ($request->status === 'inactive') {
                $query->where('stock', '=', 0);
            }
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price_per_piece' => 'required|numeric|min:0',
            'price_per_four' => 'nullable|numeric|min:0',
            'price_per_dozen' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'tier_prices' => 'nullable|array',
            'tier_prices.*.tier_name' => 'required_with:tier_prices|string|max:255',
            'tier_prices.*.min_quantity' => 'required_with:tier_prices|integer|min:1',
            'tier_prices.*.price' => 'required_with:tier_prices|numeric|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $filename, 'public');
            $data['image'] = $filename;
        }

        $product = Product::create($data);

        // Create tier prices
        if ($request->has('tier_prices')) {
            foreach ($request->tier_prices as $tierData) {
                if (!empty($tierData['tier_name']) && !empty($tierData['min_quantity']) && !empty($tierData['price'])) {
                    ProductTierPrice::create([
                        'product_id' => $product->id,
                        'tier_name' => $tierData['tier_name'],
                        'min_quantity' => $tierData['min_quantity'],
                        'price' => $tierData['price'],
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'tierPrices']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('tierPrices');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'price_per_piece' => 'required|numeric|min:0',
            'price_per_four' => 'nullable|numeric|min:0',
            'price_per_dozen' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_featured' => 'boolean',
            'tier_prices' => 'nullable|array',
            'tier_prices.*.tier_name' => 'required_with:tier_prices|string|max:255',
            'tier_prices.*.min_quantity' => 'required_with:tier_prices|integer|min:1',
            'tier_prices.*.price' => 'required_with:tier_prices|numeric|min:0',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $filename, 'public');
            $data['image'] = $filename;
        }

        $product->update($data);

        // Update tier prices
        $product->tierPrices()->delete();
        if ($request->has('tier_prices')) {
            foreach ($request->tier_prices as $tierData) {
                if (!empty($tierData['tier_name']) && !empty($tierData['min_quantity']) && !empty($tierData['price'])) {
                    ProductTierPrice::create([
                        'product_id' => $product->id,
                        'tier_name' => $tierData['tier_name'],
                        'min_quantity' => $tierData['min_quantity'],
                        'price' => $tierData['price'],
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $product->tierPrices()->delete();
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}

