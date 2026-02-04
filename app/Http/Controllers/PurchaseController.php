<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Distributor; // Pastikan ini ada jika dipakai
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <--- TAMBAHKAN INI (WAJIB)
use Illuminate\Support\Facades\Storage;
class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        // Query Dasar dengan Eager Loading Distributor (biar ringan)
        $query = Purchase::with('distributor');

        // Logika Search Sederhana (Nota)
        if ($request->has('search') && $request->search != null) {
            $query->where('note_number', 'like', '%' . $request->search . '%');
        }

        // Ambil data terbaru + Pagination
        $purchases = $query->latest()->paginate(10)->withQueryString();

        return view('purchase.index', [
            'title' => 'Purchase',
            'purchases' => $purchases
        ]);
    }

    public function create()
    {
        $distributors = Distributor::all();
        $products = Product::orderBy('name', 'asc')->get();

        return view('purchase.create', [
            'title' => 'Create Purchase',
            'distributors' => $distributors,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'note_number' => 'required|string|max:15|unique:purchases,note_number',
            'purchase_date' => 'required|date',
            'distributor_id' => 'nullable|exists:distributors,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
            // Validasi Margin (Wajib diisi, min 0%)
            'items.*.margin' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {

                // A. Simpan Header
                $purchase = Purchase::create([
                    'note_number' => $request->note_number,
                    'purchase_date' => $request->purchase_date,
                    'distributor_id' => $request->distributor_id,
                    'total_price' => 0, // Nanti diupdate
                ]);

                $grandTotal = 0;

                // B. Loop Barang
                foreach ($request->items as $item) {
                    $buyPrice = $item['price'];
                    $qty = $item['quantity'];
                    $margin = $item['margin'];

                    $subtotal = $buyPrice * $qty;
                    $grandTotal += $subtotal;

                    // Simpan Detail
                    PurchaseDetail::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $item['product_id'],
                        'purchase_price' => $buyPrice,
                        'purchase_amount' => $qty,
                        'subtotal' => $subtotal,
                        'selling_margin' => $margin, // Simpan margin ke DB
                    ]);

                    // C. Update Master Product (Stok & Harga Jual)
                    $product = Product::findOrFail($item['product_id']);

                    // Update Stok
                    $product->stock += $qty;

                    // --- LOGIKA MARGIN BARU ---
                    // Harga Jual Baru = Harga Beli + (Harga Beli * Margin%)
                    // Contoh: 10.000 + (10.000 * 10/100) = 11.000
                    $marginValue = $buyPrice * ($margin / 100);
                    $newSellingPrice = $buyPrice + $marginValue;

                    // Timpa harga jual lama dengan yang baru
                    $product->price = $newSellingPrice;

                    $product->save();
                }

                // D. Update Grand Total
                $purchase->update(['total_price' => $grandTotal]);
            });

            return redirect()->route('purchase.index')
                ->with('success', 'Purchase saved! Stock added & Selling Price updated.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Error saving purchase: ' . $e->getMessage()]);
        }
    }
    public function show($id)
    {
        // Eager loading: Ambil Purchase + Distributor + Detail Barang + Nama Produknya
        $purchase = Purchase::with(['distributor', 'details.product'])->findOrFail($id);

        return view('purchase.show', [
            'title' => 'Purchase Details',
            'purchase' => $purchase
        ]);
    }

    public function destroy($id)
    {
        $purchase = Purchase::with('details')->findOrFail($id);

        try {
            DB::transaction(function () use ($purchase) {
                // 1. Kembalikan Stok (Reverse Stock)
                foreach ($purchase->details as $detail) {
                    $product = Product::find($detail->product_id);
                    if ($product) {
                        // Kurangi stok sejumlah yang dulu dibeli
                        $product->stock -= $detail->purchase_amount;
                        $product->save();
                    }
                }

                // 2. Hapus Data Purchase (Detail akan terhapus otomatis karena cascade)
                $purchase->delete();
            });

            return redirect()->route('purchase.index')->with('success', 'Purchase deleted and stock reversed successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting purchase: ' . $e->getMessage());
        }
    }

    public function checkUniqueNoteNumber(Request $request)
    {
        $noteNumber = $request->input('note_number');

        // Cek di database apakah nomor nota sudah ada
        $exists = Purchase::where('note_number', $noteNumber)->exists();

        return response()->json(['exists' => $exists]);
    }

}
