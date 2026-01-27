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
            'title' => 'Tambah Distributor',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_distributor' => 'required|min:3|max:255',
            'alamat'           => 'required',
            'telepon'          => 'required|numeric',
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
            'nama_distributor' => 'required|min:3|max:255',
            'alamat'           => 'required',
            'telepon'          => 'required|numeric',
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
