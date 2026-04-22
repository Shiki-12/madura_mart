<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Purchase::with('distributor');

        if ($request->has('search') && $request->search != null) {
            $query->where('note_number', 'like', '%' . $request->search . '%');
        }

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
        $request->validate([
            'note_number' => 'required|string|max:15|unique:purchases,note_number',
            'purchase_date' => 'required|date',
            'distributor_id' => 'nullable|exists:distributors,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
            'items.*.margin' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $purchase = Purchase::create([
                    'note_number' => $request->note_number,
                    'purchase_date' => $request->purchase_date,
                    'distributor_id' => $request->distributor_id,
                    'total_price' => 0,
                ]);

                $grandTotal = 0;

                foreach ($request->items as $item) {
                    $buyPrice = $item['price'];
                    $qty = $item['quantity'];
                    $margin = $item['margin'];

                    $subtotal = $buyPrice * $qty;
                    $grandTotal += $subtotal;

                    PurchaseDetail::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $item['product_id'],
                        'purchase_price' => $buyPrice,
                        'purchase_amount' => $qty,
                        'subtotal' => $subtotal,
                        'selling_margin' => $margin,
                    ]);

                    $product = Product::findOrFail($item['product_id']);

                    $product->stock += $qty;

                    $marginValue = $buyPrice * ($margin / 100);
                    $newSellingPrice = $buyPrice + $marginValue;

                    $product->price = $newSellingPrice;

                    $product->save();
                }

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
                foreach ($purchase->details as $detail) {
                    $product = Product::find($detail->product_id);
                    if ($product) {
                        $product->stock -= $detail->purchase_amount;
                        $product->save();
                    }
                }

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

        $exists = Purchase::where('note_number', $noteNumber)->exists();

        return response()->json(['exists' => $exists]);
    }
}
