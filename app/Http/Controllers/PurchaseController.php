<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function confirmPassword(Request $request, Purchase $purchase)
    {
        $request->validate([
            'password' => 'required|string',
            'action' => 'required|in:edit,delete',
        ]);

        $user = auth()->user();

        if (!$user || !in_array($user->role, ['owner', 'admin'], true)) {
            abort(403);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password is incorrect.',
            ], 403);
        }

        $request->session()->put(
            $this->purchasePasswordSessionKey($purchase->id, $request->action),
            now()->timestamp
        );

        return response()->json([
            'success' => true,
            'message' => 'Password confirmed.',
            'redirect' => route('purchase.edit', $purchase->id),
        ]);
    }

    public function edit($id)
    {
        if (!$this->hasRecentPurchasePasswordConfirmation($id, 'edit')) {
            return redirect()->route('purchase.index')
                ->with('error', 'Please confirm your password before editing this purchase.');
        }

        $purchase = Purchase::with(['details.product', 'distributor'])->findOrFail($id);
        $distributors = Distributor::all();
        $products = Product::orderBy('name', 'asc')->get();

        return view('purchase.edit', [
            'title' => 'Edit Purchase',
            'purchase' => $purchase,
            'distributors' => $distributors,
            'products' => $products,
        ]);
    }

    public function update(Request $request, $id)
    {
        if (!$this->hasRecentPurchasePasswordConfirmation($id, 'edit')) {
            return redirect()->route('purchase.index')
                ->with('error', 'Please confirm your password before updating this purchase.');
        }

        $request->validate([
            'note_number' => 'required|string|max:15|unique:purchases,note_number,' . $id,
            'purchase_date' => 'required|date',
            'distributor_id' => 'nullable|exists:distributors,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
            'items.*.margin' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $purchase = Purchase::with('details')->lockForUpdate()->findOrFail($id);

                foreach ($purchase->details as $detail) {
                    $product = Product::whereKey($detail->product_id)->lockForUpdate()->first();

                    if ($product) {
                        $product->stock -= $detail->purchase_amount;
                        $product->save();
                    }
                }

                $purchase->details()->delete();

                $purchase->update([
                    'note_number' => $request->note_number,
                    'purchase_date' => $request->purchase_date,
                    'distributor_id' => $request->distributor_id,
                    'total_price' => 0,
                ]);

                $grandTotal = 0;

                foreach ($request->items as $item) {
                    $buyPrice = (int) $item['price'];
                    $qty = (int) $item['quantity'];
                    $margin = (float) $item['margin'];
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

                    $product = Product::whereKey($item['product_id'])->lockForUpdate()->firstOrFail();
                    $product->stock += $qty;
                    $product->price = (int) round($buyPrice + ($buyPrice * ($margin / 100)));
                    $product->save();
                }

                $purchase->update(['total_price' => $grandTotal]);
            });

            $this->forgetPurchasePasswordConfirmation($id, 'edit');

            return redirect()->route('purchase.index')
                ->with('success', 'Purchase has been updated.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating purchase: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        if (!$this->hasRecentPurchasePasswordConfirmation($id, 'delete')) {
            return redirect()->route('purchase.index')
                ->with('error', 'Please confirm your password before deleting this purchase.');
        }

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

            $this->forgetPurchasePasswordConfirmation($id, 'delete');

            return redirect()->route('purchase.index')->with('success', 'Purchase has been deleted.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting purchase: ' . $e->getMessage());
        }
    }

    public function checkUniqueNoteNumber(Request $request)
    {
        $noteNumber = $request->input('note_number');
        $purchaseId = $request->input('purchase_id');

        $exists = Purchase::where('note_number', $noteNumber)
            ->when($purchaseId, fn ($query) => $query->where('id', '!=', $purchaseId))
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    private function purchasePasswordSessionKey(int|string $purchaseId, string $action): string
    {
        return "purchase_password_confirmed.{$purchaseId}.{$action}";
    }

    private function hasRecentPurchasePasswordConfirmation(int|string $purchaseId, string $action): bool
    {
        $confirmedAt = session($this->purchasePasswordSessionKey($purchaseId, $action));

        return $confirmedAt && now()->timestamp - $confirmedAt <= 600;
    }

    private function forgetPurchasePasswordConfirmation(int|string $purchaseId, string $action): void
    {
        session()->forget($this->purchasePasswordSessionKey($purchaseId, $action));
    }
}
