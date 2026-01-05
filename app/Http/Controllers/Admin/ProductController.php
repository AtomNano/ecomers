<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Stock filter
        if ($request->filled('stock')) {
            if ($request->stock === 'low') {
                $query->where('stock', '<=', 10);
            } elseif ($request->stock === 'medium') {
                $query->whereBetween('stock', [11, 50]);
            } elseif ($request->stock === 'high') {
                $query->where('stock', '>', 50);
            }
        }
        
        $products = $query->orderBy('name')->paginate(12)->withQueryString();
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
        // Validasi input dengan strict rules untuk pricing
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'description' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            
            // Tiered Pricing - semua required, tapi tidak enforce unit > bulk > dozen
            // (User bebas set harga, sistem akan otomatis pilih termurah)
            'price_unit' => 'required|numeric|min:100|regex:/^\d+(\.\d{1,2})?$/',
            'price_bulk_4' => 'nullable|numeric|min:100|regex:/^\d+(\.\d{1,2})?$/',
            'price_dozen' => 'nullable|numeric|min:100|regex:/^\d+(\.\d{1,2})?$/',
            
            // Flexible quantity settings
            'bulk_min_qty' => 'nullable|integer|min:2|max:100',
            'box_item_count' => 'nullable|integer|min:2|max:999',
            
            // Stock management
            'stock' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_featured' => 'nullable|boolean',
            
            // Image upload - max 2MB
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'name.unique' => 'Nama produk sudah digunakan',
            'price_unit.regex' => 'Format harga tidak valid (gunakan format: 3500 atau 3500.50)',
            'price_bulk_4.regex' => 'Format harga tidak valid (gunakan format: 3500 atau 3500.50)',
            'price_dozen.regex' => 'Format harga tidak valid (gunakan format: 3500 atau 3500.50)',
            'image.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        // Set default jika tidak ada
        $validated['unit'] = $validated['unit'] ?? 'Pcs';
        $validated['bulk_min_qty'] = $validated['bulk_min_qty'] ?? 4;
        $validated['box_item_count'] = $validated['box_item_count'] ?? 12;
        $validated['is_featured'] = $validated['is_featured'] ?? false;
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($request->old('image')) {
                \Storage::disk('public')->delete($request->old('image'));
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        
        Product::create($validated);
        
        return redirect()->route('admin.products.index')
                        ->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Validasi dengan slug ignore produk saat ini
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'required|string|min:10',
            'category_id' => 'required|exists:categories,id',
            
            // Tiered Pricing
            'price_unit' => 'required|numeric|min:100|regex:/^\d+(\.\d{1,2})?$/',
            'price_bulk_4' => 'nullable|numeric|min:100|regex:/^\d+(\.\d{1,2})?$/',
            'price_dozen' => 'nullable|numeric|min:100|regex:/^\d+(\.\d{1,2})?$/',
            
            // Flexible quantity settings
            'bulk_min_qty' => 'nullable|integer|min:2|max:100',
            'box_item_count' => 'nullable|integer|min:2|max:999',
            
            // Stock management
            'stock' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_featured' => 'nullable|boolean',
            
            // Image - optional untuk update
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'name.unique' => 'Nama produk sudah digunakan produk lain',
            'price_unit.regex' => 'Format harga tidak valid (gunakan format: 3500 atau 3500.50)',
            'price_bulk_4.regex' => 'Format harga tidak valid (gunakan format: 3500 atau 3500.50)',
            'price_dozen.regex' => 'Format harga tidak valid (gunakan format: 3500 atau 3500.50)',
            'image.max' => 'Ukuran gambar maksimal 2MB'
        ]);

        $validated['unit'] = $validated['unit'] ?? 'Pcs';
        $validated['bulk_min_qty'] = $validated['bulk_min_qty'] ?? 4;
        $validated['box_item_count'] = $validated['box_item_count'] ?? 12;
        $validated['is_featured'] = $validated['is_featured'] ?? false;
        
        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        
        $product->update($validated);
        
        return redirect()->route('admin.products.index')
                        ->with('success', 'Produk berhasil diperbarui');
    }
    
    public function destroy(Product $product)
    {
        // Check if product has been ordered
        if ($product->orderItems()->exists()) {
            return redirect()->route('admin.products.index')
                            ->with('error', 'Tidak bisa menghapus produk ini. Produk sudah pernah diorder. Silakan ubah statusnya menjadi tidak aktif (uncheck Featured) untuk menyembunyikannya.');
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
                        ->with('success', 'Produk berhasil dihapus');
    }
}
