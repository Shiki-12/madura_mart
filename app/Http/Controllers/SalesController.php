<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data penjualan + nama kasir (user)
        $query = Sale::with('user');

        // Filter Tanggal (Optional, buat nanti)
        if ($request->has('date') && $request->date != null) {
            $query->whereDate('sale_date', $request->date);
        }

        $sales = $query->latest()->paginate(10);

        return view('sales.index', [
            'title' => 'Sales History',
            'sales' => $sales
        ]);
    }

    public function create()
    {
        // Hanya ambil produk yang stoknya ADA (> 0)
        // Kita urutkan nama biar gampang dicari
        $products = Product::where('stock', '>', 0)->orderBy('name', 'asc')->get();

        return view('sales.create', [
            'title' => 'New Transaction',
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_date' => 'required|date',
            'items'     => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Buat Header Penjualan
                $sale = Sale::create([
                    'sale_date'   => $request->sale_date,
                    'total_price' => 0, // Hitung nanti
                    'user_id'     => Auth::id() ?? 1, // Ambil ID user yang login (sementara default 1 jika belum login)
                ]);

                $grandTotal = 0;

                // 2. Loop Barang Belanjaan
                foreach ($request->items as $item) {
                    // AMBIL DATA PRODUK ASLI DARI DB (PENTING!)
                    // Jangan percaya harga dari input form, ambil harga dari database biar aman.
                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                    // Cek Stok Cukup Gak?
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok {$product->name} tidak cukup! Sisa: {$product->stock}");
                    }

                    // Hitung Subtotal
                    $subtotal = $product->price * $item['quantity'];
                    $grandTotal += $subtotal;

                    // Simpan Detail
                    SaleDetail::create([
                        'sale_id'       => $sale->id,
                        'product_id'    => $product->id,
                        'selling_price' => $product->price, // Harga jual saat ini
                        'quantity'      => $item['quantity'],
                        'subtotal'      => $subtotal,
                    ]);

                    // POTONG STOK (Stok Berkurang)
                    $product->stock -= $item['quantity'];
                    $product->save();
                }

                // 3. Update Total Bayar
                $sale->update(['total_price' => $grandTotal]);
            });

            return redirect()->route('sales.index')->with('success', 'Transaksi Berhasil! Stok berkurang.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal Transaksi: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $sale = Sale::with(['details.product', 'user'])->findOrFail($id);
        return view('sales.show', [
            'title' => 'Struk Penjualan',
            'sale' => $sale
        ]);
    }

    public function destroy($id)
    {
        // Fitur Void/Batal Transaksi
        // Stok harus dikembalikan (Refund stok)
        $sale = Sale::with('details')->findOrFail($id);

        try {
            DB::transaction(function () use ($sale) {
                foreach ($sale->details as $detail) {
                    $product = Product::find($detail->product_id);
                    if ($product) {
                        $product->stock += $detail->quantity; // Balikin stok
                        $product->save();
                    }
                }
                $sale->delete();
            });

            return redirect()->route('sales.index')->with('success', 'Transaksi dibatalkan. Stok dikembalikan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}