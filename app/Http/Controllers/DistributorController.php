<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index()
    {
        return view('distributor.index', [
            'title' => 'Distributor',
            'data' => Distributor::all()
        ]);
    }

    public function create()
    {
         return view('distributor.create', [
            'title' => 'Create Distributor',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:50',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:30',
        ]);

        Distributor::create($validated);

        return redirect()->route('distributors.index')->with('success', 'Data berhasil disimpan');
    }

    public function show(Distributor $distributor)
    {
        return view('distributor.show', compact('distributor'));
    }

    public function edit(Distributor $distributor)
    {
        return view('distributor.edit', compact('distributor'));
    }

    public function update(Request $request, Distributor $distributor)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:50',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:30',
        ]);

        $distributor->update($validated);

        return redirect()->route('distributors.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();
        return redirect()->route('distributors.index')->with('success', 'Data berhasil dihapus');
    }
}
