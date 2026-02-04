<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

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
        $distributors = \App\Models\Distributor::all();
        $products = \App\Models\Product::orderBy('name', 'asc')->get();

        return view('purchase.create', [
            'title' => 'Create Purchase',
            'distributors' => $distributors,
            'products' => $products
        ]);
    }
}