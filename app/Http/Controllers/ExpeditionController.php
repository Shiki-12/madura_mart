<?php

namespace App\Http\Controllers;

use App\Models\Expedition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpeditionController extends Controller
{
    public function index()
    {
        $expeditions = Expedition::withCount('deliveries')->latest()->paginate(10);

        return view('courier-management.expeditions.index', [
            'title'       => 'Expedition Management',
            'expeditions' => $expeditions,
        ]);
    }

    public function create()
    {
        return view('courier-management.expeditions.create', [
            'title' => 'Add New Expedition',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:50|unique:expeditions,name',
            'address'      => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'picture'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'address', 'phone_number']);

        if ($request->hasFile('picture')) {
            $data['picture'] = $request->file('picture')->store('expeditions', 'public');
        }

        Expedition::create($data);

        return redirect()->route('expeditions.index')->with('success', 'Expedition created successfully.');
    }

    public function edit(Expedition $expedition)
    {
        return view('courier-management.expeditions.edit', [
            'title'      => 'Edit Expedition',
            'expedition' => $expedition,
        ]);
    }

    public function update(Request $request, Expedition $expedition)
    {
        $request->validate([
            'name'         => 'required|string|max:50|unique:expeditions,name,' . $expedition->id,
            'address'      => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'picture'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'address', 'phone_number']);

        if ($request->hasFile('picture')) {
            if ($expedition->picture && Storage::exists('public/' . $expedition->picture)) {
                Storage::delete('public/' . $expedition->picture);
            }
            $data['picture'] = $request->file('picture')->store('expeditions', 'public');
        }

        $expedition->update($data);

        return redirect()->route('expeditions.index')->with('success', 'Expedition updated successfully.');
    }

    public function destroy(Expedition $expedition)
    {
        if ($expedition->picture && Storage::exists('public/' . $expedition->picture)) {
            Storage::delete('public/' . $expedition->picture);
        }

        $expedition->delete();

        return redirect()->route('expeditions.index')->with('success', 'Expedition deleted successfully.');
    }
}
