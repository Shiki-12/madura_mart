@extends('layout.master')

@section('title', 'Add User')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Create New User</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            {{-- Nama --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                            </div>

                            {{-- Role (PENTING) --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role / Access Level <span class="text-danger">*</span></label>
                                <select name="role" class="form-select" required>
                                    <option value="" disabled selected>-- Select Role --</option>
                                    <option value="admin">Admin (Staff)</option>
                                    <option value="courier">Courier</option>
                                    <option value="customer">Customer</option>
                                    <option value="owner">Owner</option>
                                </select>
                                <small class="text-muted text-xs">Admin can access Sales & Products. Courier only Delivery.</small>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                            </div>
                        </div>

                        <div class="row">
                            {{-- Phone --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>

                            {{-- Foto Profil --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profile Picture</label>
                                <input type="file" name="picture" class="form-control" accept="image/*">
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-4">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('users.index') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" class="btn bg-gradient-primary">Save User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection