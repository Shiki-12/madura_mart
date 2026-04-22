<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->where('stock', '>', 0);

        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category != 'all') {
            $query->where('type', $request->category);
        }

        $products = $query->orderBy('name', 'asc')->paginate(12)->withQueryString();

        $categories = Product::where('is_active', true)
            ->where('stock', '>', 0)
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view('shop.index', [
            'title' => 'Belanja',
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:500',
            'payment_method' => 'required|in:transfer,cod',
            'notes' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $grandTotal = 0;
                $orderItems = [];

                foreach ($request->items as $item) {
                    $product = Product::where('id', $item['product_id'])
                        ->where('is_active', true)
                        ->lockForUpdate()
                        ->first();

                    if (!$product) {
                        throw new \Exception("Produk tidak ditemukan atau sudah tidak aktif.");
                    }

                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok '{$product->name}' tidak cukup. Tersisa: {$product->stock} pcs.");
                    }

                    $subtotal = $product->price * $item['quantity'];
                    $grandTotal += $subtotal;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ];

                    $product->stock -= $item['quantity'];
                    $product->save();
                }

                $invoiceNumber = 'INV/' . date('Y') . '/' . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

                $order = Order::create([
                    'invoice_number' => $invoiceNumber,
                    'user_id' => Auth::id(),
                    'delivery_address' => $request->delivery_address,
                    'order_date' => now()->toDateString(),
                    'status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'total_price' => $grandTotal,
                    'notes' => $request->notes,
                ]);

                foreach ($orderItems as $oi) {
                    $order->items()->create($oi);
                }
            });

            return redirect()->route('shop.index')->with('success', 'Pesanan berhasil dibuat! Admin akan segera memproses pesanan Anda.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
