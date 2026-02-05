@extends('layout.master')

@section('title', 'My Profile')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">

                @if(session('success'))
                    <div class="alert alert-success text-white mb-3">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">My Profile</h6>
                            <span class="badge bg-gradient-primary">{{ ucfirst($user->role) }}</span>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Form Profile --}}
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 mb-3 text-center">
                                    <div class="position-relative d-inline-block">
                                        @if ($user->picture)
                                            <img src="{{ asset('storage/' . $user->picture) }}"
                                                class="avatar avatar-xl rounded-circle shadow-sm"
                                                style="object-fit: cover; width: 100px; height: 100px;">
                                        @else
                                            <div class="avatar avatar-xl bg-gradient-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                                style="width: 100px; height: 100px;">
                                                <span class="text-white font-weight-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- Nama --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" required
                                        value="{{ old('name', $user->name) }}">
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" required
                                        value="{{ old('email', $user->email) }}">
                                </div>
                            </div>

                            <div class="row">
                                {{-- Phone --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ old('phone', $user->phone_number) }}">
                                </div>

                                {{-- Upload Foto --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Change Photo</label>
                                    <input type="file" name="picture" class="form-control" accept="image/*">
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <hr class="horizontal dark my-4">

                            {{-- Ganti Password --}}
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Change Password</h6>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        New Password
                                        <small class="text-muted ms-1">(Leave blank if not changing)</small>
                                    </label>
                                    <input type="password" name="password" class="form-control" minlength="6"
                                        placeholder="******">
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="submit" class="btn bg-gradient-dark mb-0">
                                    <i class="fas fa-save me-1"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
