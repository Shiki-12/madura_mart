@extends('layout.master')

@section('title', 'Edit User')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Edit User: {{ $user->name }}</h6>
                            {{-- Badge Status di Header --}}
                            @if ($user->is_active)
                                <span class="badge bg-gradient-success">Active Account</span>
                            @else
                                <span class="badge bg-gradient-danger">Inactive / Suspended</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Form Edit --}}
                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- BAGIAN 1: IDENTITAS & AKSES --}}
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Account Settings</h6>
                            <div class="row">
                                {{-- Nama --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        value="{{ old('name', $user->name) }}">
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required
                                        value="{{ old('email', $user->email) }}">
                                </div>
                            </div>

                            <div class="row">
                                {{-- Role --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Role / Access Level <span class="text-danger">*</span></label>
                                    {{-- Proteksi: Owner tidak bisa menurunkan jabatan Owner lain (opsional) --}}
                                    <select name="role" class="form-select" required>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Staff)
                                        </option>
                                        <option value="courier" {{ $user->role == 'courier' ? 'selected' : '' }}>Courier
                                        </option>
                                        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>
                                            Customer</option>
                                        <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>Owner
                                        </option>
                                    </select>
                                </div>

                                {{-- STATUS SWITCH (FITUR BARU) --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Account Status</label>
                                    <div class="d-flex align-items-center border rounded p-2">
                                        {{-- Trik Hidden Input agar checkbox yang tidak dicentang tetap mengirim nilai "0" --}}
                                        <input type="hidden" name="is_active" value="0">

                                        <div class="form-check form-switch mb-0">
                                            {{-- Cegah user menonaktifkan diri sendiri --}}
                                            <input class="form-check-input" type="checkbox" id="activeSwitch"
                                                name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}
                                                {{ auth()->id() == $user->id ? 'disabled' : '' }}>

                                            <label class="form-check-label font-weight-bold ms-2" for="activeSwitch">
                                                {{ $user->is_active ? 'User is Active' : 'User is Inactive' }}
                                            </label>
                                        </div>
                                    </div>
                                    <small class="text-xxs text-muted">
                                        @if (auth()->id() == $user->id)
                                            You cannot deactivate your own account.
                                        @else
                                            If unchecked, user cannot login.
                                        @endif
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Password (Opsional) --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        Password
                                        <small class="text-muted ms-1">(Leave blank to keep current)</small>
                                    </label>
                                    <input type="password" name="password" class="form-control" minlength="6"
                                        placeholder="Type new password only if you want to change it...">
                                </div>
                            </div>

                            <hr class="horizontal dark my-4">

                            {{-- BAGIAN 2: KONTAK & PROFIL --}}
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Contact Information</h6>

                            <div class="row">
                                {{-- Phone --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $user->phone_number) }}">
                                </div>

                                {{-- Foto Profil --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profile Picture</label>
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($user->picture)
                                            <img src="{{ asset('storage/' . $user->picture) }}"
                                                class="avatar avatar-sm border-radius-lg shadow-sm"
                                                style="object-fit: cover;">
                                        @else
                                            <div
                                                class="avatar avatar-sm bg-gradient-primary border-radius-lg shadow-sm d-flex align-items-center justify-content-center">
                                                <span
                                                    class="text-white font-weight-bold">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif

                                        <div class="w-100">
                                            <input type="file" name="picture" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-4">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('users.index') }}" class="btn btn-light mb-0">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary mb-0">
                                    <i class="fas fa-save me-1"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
