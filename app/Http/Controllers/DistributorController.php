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
            'distributors' => Distributor::all(),
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
            'title' => 'Edit Distributor',
        ]);
    }

    // Di dalam DistributorController method store()
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:distributors,name',
            'address' => 'required|string',
            'phone_number' => 'required|numeric|unique:distributors,phone_number',
        ], [
            // Custom Messages (Agar muncul bahasa Indonesia seperti screenshot)
            'name.unique' => 'Nama Distributor ini sudah terdaftar, mohon gunakan nama lain.',
            'phone_number.unique' => 'Nomor Telepon ini sudah terdaftar, mohon gunakan nomor lain.',
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
            return redirect()->route('distributors.edit', $id)->with('error', 'Distributor '.$request->name.' data with the same address '.$request->address.' and phone number '.$request->phone_number.' already exists. Please use different data.');
        }

        $distributor->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('distributors.index')->with('success', 'The Distributor Data, '.$namaLama.' become '.$request->name.', has been successfully updated');
    }

    public function destroy($id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->delete();

        return redirect()->route('distributors.index')->with('success', 'Data distributor berhasil dihapus!');
    }

    public function checkDuplicate(Request $request)
    {
        $exists = Distributor::where('name', $request->name)
            ->where('address', $request->address)
            ->where('phone_number', $request->phone_number)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function checkUnique(Request $request)
    {
        $exists = false;
        $message = '';

        // Cek Nama
        if ($request->has('name')) {
            $exists = Distributor::where('name', $request->name)->exists();
            $message = $exists ? 'Nama Distributor ini sudah terdaftar, mohon gunakan nama lain.' : '';
        }

        // Cek No HP
        if ($request->has('phone_number')) {
            $exists = Distributor::where('phone_number', $request->phone_number)->exists();
            $message = $exists ? 'Nomor Telepon ini sudah terdaftar, mohon gunakan nomor lain.' : '';
        }

        return response()->json([
            'exists' => $exists,
            'message' => $message,
        ]);
    }
}
