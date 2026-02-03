<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk hapus gambar

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query Builder
        $query = Product::query();

        // 2. Logika Search (Nama Produk atau SKU)
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        // 3. Logika Filter Kategori
        if ($request->has('category') && $request->category != 'All Categories') {
            $query->where('type', $request->category);
        }

        // 4. Logika Filter Status
        if ($request->has('status') && $request->status != 'All Status') {
            if ($request->status == 'active') {
                $query->where('stock', '>', 0); // Active jika stok ada
            } elseif ($request->status == 'out_of_stock') {
                $query->where('stock', '<=', 0); // Out of stock jika 0
            }
        }

        // 5. Ambil data (Latest)
        // Saya ganti get() jadi simplePaginate(10) agar pagination jalan jika data banyak
        $products = $query->latest()->simplePaginate(10)->withQueryString();

        return view('products.index', [
            'title' => 'Products',
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create', [
            'title' => 'Add New Product',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        // Serial number harus unique di tabel products
        // Gambar opsional, tapi jika ada harus berupa image (jpg/png) max 2MB
        $validated = $request->validate([
            'serial_number' => 'required|string|max:20|unique:products,serial_number',
            'name' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'expiration_date' => 'nullable|date',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'serial_number.unique' => 'Serial Number (SKU) ini sudah digunakan.',
            'picture.max' => 'Ukuran gambar maksimal 2MB.',
            'picture.image' => 'File harus berupa gambar.',
        ]);

        // 2. Handle Upload Gambar
        $path = null;
        if ($request->hasFile('picture')) {
            // Simpan ke folder 'storage/app/public/product-images'
            // Pastikan Anda sudah menjalankan: php artisan storage:link
            $path = $request->file('picture')->store('product-images', 'public');
        }

        // 3. Simpan ke Database
        Product::create([
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'type' => $request->type, // Ini dari Select Option
            'expiration_date' => $request->expiration_date,
            'price' => $request->price,
            'stock' => $request->stock,
            'picture' => $path, // Simpan path filenya saja string
        ]);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', [
            'title' => 'Edit Product',
            'product' => $product,
        ]);
    }

    public function update(Request $request, string $id)
    {
        // 1. Validasi
        $validated = $request->validate([
            'serial_number' => 'required|string|max:20|unique:products,serial_number,'.$id,
            'name' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'expiration_date' => 'nullable|date',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'is_active' tidak perlu divalidasi karena kita handle manual di bawah
        ]);

        $product = Product::findOrFail($id);

        // 2. Handle Checkbox Status
        // Jika checkbox dicentang, request akan punya 'is_active' -> true
        // Jika tidak dicentang, request tidak punya 'is_active' -> false
        $isActive = $request->has('is_active');

        // 3. Handle Gambar
        $path = $product->picture;
        if ($request->hasFile('picture')) {
            if ($product->picture && Storage::disk('public')->exists($product->picture)) {
                Storage::disk('public')->delete($product->picture);
            }
            $path = $request->file('picture')->store('product-images', 'public');
        }

        // 4. Update Database
        $product->update([
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'type' => $request->type,
            'expiration_date' => $request->expiration_date,
            'price' => $request->price,
            'stock' => $request->stock,
            'picture' => $path,
            'is_active' => $isActive, // Simpan status baru
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Hapus file gambar dari storage (wajib agar tidak nyampah)
        if ($product->picture && Storage::disk('public')->exists($product->picture)) {
            Storage::disk('public')->delete($product->picture);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
