<?php

namespace App\Http\Controllers; // <--- Pastikan ini benar

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Fitur Search sederhana
        $query = User::query();
        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%');
        }

        // Urutkan: Owner paling atas, lalu Admin, lalu Customer
        $users = $query->orderByRaw("FIELD(role, 'owner', 'admin', 'courier', 'customer')")->paginate(10);

        return view('users.index', [
            'title' => 'User Management',
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('users.create', ['title' => 'Add New User']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:owner,admin,courier,customer',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload Foto jika ada
        $picturePath = null;
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi Password
            'role' => $request->role,
            'phone_number' => $request->phone,
            'address' => $request->address,
            'picture' => $picturePath,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'title' => 'Edit User',
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:owner,admin,courier,customer',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone_number' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->is_active,
        ];

        // Cek jika password diisi (kalau kosong berarti gak mau ganti password)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Cek jika ada upload foto baru
        if ($request->hasFile('picture')) {
            // Hapus foto lama jika ada (opsional, biar hemat storage)
            if ($user->picture && Storage::exists('public/'.$user->picture)) {
                Storage::delete('public/'.$user->picture);
            }
            $data['picture'] = $request->file('picture')->store('profile_pictures', 'public');
        }
        if ($request->has('is_active')) {
            $data['is_active'] = $request->is_active;
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Cegah menghapus diri sendiri
        if (auth()->id() == $user->id) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function profile()
    {
        // Ambil data user yang sedang login
        $user = auth()->user();

        return view('auth.profile', [
            'title' => 'My Profile',
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user(); // Pastikan yang diedit adalah DIRI SENDIRI

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|numeric',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:6',
        ]);

        // Data yang boleh diupdate (JANGAN MASUKKAN ROLE DI SINI)
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'address' => $request->address,
        ];

        // Cek Password
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Cek Gambar
        if ($request->hasFile('picture')) {
            // Hapus gambar lama jika ada
            if ($user->picture) {
                Storage::disk('public')->delete($user->picture);
            }
            $data['picture'] = $request->file('picture')->store('profiles', 'public');
        }

        // Simpan ke database (Pakai instance user yang sedang login)
        /** @var \App\Models\User $user */
        $user->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}
