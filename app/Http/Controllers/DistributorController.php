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
        'distributors' => Distributor::all()
    ]);
}

    public function create()
    {
         return view('distributor.create', [
            'title' => 'Create Distributor',
        ]);
    }

    public function edit(Distributor $distributor)
    {
        return view('distributor.edit', [
            'distributor' => $distributor,
            'title' => 'Edit Distributor'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|max:30',
        ]);

        Distributor::create($validated);

        return redirect()->route('distributors.index')->with('success', 'Data berhasil disimpan');
    }

    public function show(Distributor $distributor)
    {
        return view('distributor.show', compact('distributor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:30',
        ]);
        $distributor = Distributor::findOrFail($id);


        $namaLama = $distributor->name;
        $cekDuplikat = Distributor::where('name', $request->name)
            ->where('address', $request->address)
            ->where('phone_number', $request->phone_number)
            ->where('id', '!=', $id)
            ->first();

        if ($cekDuplikat) {
            return redirect()->route('distributors.edit', $id)->with('error', 'Distributor ' . $request->name . ' data with the same address ' . $request->address . ' and phone number ' . $request->phone_number . ' already exists. Please use different data.');
        }

        $distributor->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('distributors.index')->with('success', 'The Distributor Data, ' . $namaLama . ' become ' . $request->name . ', has been successfully updated');
    }

    public function destroy($id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->delete();

        return redirect()->route('distributors.index')->with('success', 'Data distributor berhasil dihapus!');
    }
}
