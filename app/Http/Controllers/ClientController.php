<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a paginated list of customers.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');

        // Search by name, email, or phone
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->status !== null && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $clients = $query->latest()->paginate(10);

        return view('clients.index', [
            'title'   => 'Client Management',
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        return view('clients.create', [
            'title' => 'Add New Client',
        ]);
    }

    /**
     * Store a newly created customer.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string|max:15',
            'address'  => 'nullable|string|max:500',
            'picture'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
        }

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => 'customer',
            'phone_number' => $request->phone,
            'address'      => $request->address,
            'picture'      => $picturePath,
            'is_active'    => 1,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    /**
     * Show client details.
     */
    public function show(User $client)
    {
        return redirect()->route('clients.edit', $client);
    }

    /**
     * Show form for editing a customer.
     */
    public function edit(User $client)
    {
        // Guard: only allow editing customers
        if ($client->role !== 'customer') {
            abort(404);
        }

        return view('clients.edit', [
            'title'  => 'Edit Client',
            'client' => $client,
        ]);
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, User $client)
    {
        if ($client->role !== 'customer') {
            abort(404);
        }

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $client->id,
            'phone'   => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name'         => $request->name,
            'email'        => $request->email,
            'phone_number' => $request->phone,
            'address'      => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('picture')) {
            if ($client->picture && Storage::exists('public/' . $client->picture)) {
                Storage::delete('public/' . $client->picture);
            }
            $data['picture'] = $request->file('picture')->store('profile_pictures', 'public');
        }

        if ($request->has('is_active')) {
            $data['is_active'] = $request->is_active;
        }

        $client->update($data);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified customer.
     */
    public function destroy(User $client)
    {
        if ($client->role !== 'customer') {
            abort(404);
        }

        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
