<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk hapus gambar

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
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
        // Kirim data distributor ke view agar bisa dipilih
        return view('products.create', [
            'title' => 'Add New Product',
            'distributors' => Distributor::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'distributor_id' => 'required|exists:distributors,id', // Validasi distributor
            'serial_number' => 'required|string|max:20|unique:products,serial_number',
            'name' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'description' => 'nullable|string', // Validasi deskripsi
            'expiration_date' => 'nullable|date',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('product-images', 'public');
        }

        Product::create([
            'distributor_id' => $request->distributor_id,
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'expiration_date' => $request->expiration_date,
            'price' => $request->price,
            'stock' => $request->stock,
            'picture' => $path,
            'is_active' => true,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $product = Product::with('distributor')->findOrFail($id);

        return view('products.show', [
            'title' => 'Product Detail',
            'product' => $product,
        ]);
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', [
            'title' => 'Edit Product',
            'product' => $product,
            'distributors' => Distributor::all(), // Kirim list distributor lagi
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'distributor_id' => 'required|exists:distributors,id',
            'serial_number' => 'required|string|max:20|unique:products,serial_number,'.$id,
            'name' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'expiration_date' => 'nullable|date',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $isActive = $request->has('is_active');

        $path = $product->picture;
        if ($request->hasFile('picture')) {
            if ($product->picture && Storage::disk('public')->exists($product->picture)) {
                Storage::disk('public')->delete($product->picture);
            }
            $path = $request->file('picture')->store('product-images', 'public');
        }

        $product->update([
            'distributor_id' => $request->distributor_id,
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'expiration_date' => $request->expiration_date,
            'price' => $request->price,
            'stock' => $request->stock,
            'picture' => $path,
            'is_active' => $isActive,
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
    // Update di app/Http/Controllers/ProductController.php

    public function checkUnique(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $ignoreId = $request->input('ignore_id'); // ID produk yang sedang diedit (jika ada)

        if (! in_array($field, ['serial_number', 'name'])) {
            return response()->json(['exists' => false]);
        }

        $query = Product::where($field, $value);

        // Jika ada ignore_id, kecualikan ID tersebut dari pencarian
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }
}
