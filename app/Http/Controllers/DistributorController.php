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
        // 1. Validasi Input
        // Tetap gunakan validasi unique yang mengabaikan ID sendiri agar aman dari error SQL
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:distributors,name,' . $id,
            'address' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
        ], [
            'name.unique' => 'Nama Distributor ini sudah terdaftar, mohon gunakan nama lain.',
            'name.max' => 'Nama Distributor tidak boleh lebih dari 50 karakter.',
        ]);

        // 2. Ambil Data Lama dari Database
        $distributor = Distributor::findOrFail($id);

        // 3. LOGIKA DETEKSI "TIDAK ADA PERUBAHAN"
        // Kita bandingkan data input ($request) dengan data lama ($distributor)
        if (
            $request->name == $distributor->name &&
            $request->address == $distributor->address &&
            $request->phone_number == $distributor->phone_number
        ) {
            // JIKA SEMUA SAMA: Kembalikan dengan pesan Error
            // redirect()->back() akan mengembalikan user ke halaman Edit
            return redirect()->back()->with('error', 'Tidak ada perubahan data yang dilakukan.');
        }

        // Simpan nama lama untuk pesan sukses (opsional)
        $namaLama = $distributor->name;

        // 4. Lakukan Update (Hanya jika lolos pengecekan di atas)
        $distributor->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('distributors.index')
            ->with('success', 'Data Distributor ' . $namaLama . ' berhasil diubah menjadi ' . $request->name);
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
