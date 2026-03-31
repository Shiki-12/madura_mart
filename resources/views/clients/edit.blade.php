@extends('layout.master')

@section('title', 'Edit Client')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-lg">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="font-weight-bolder">Edit Client</h5>
                                <p class="text-sm text-secondary mb-0">Update customer account information.</p>
                            </div>
                            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary btn-sm mb-0">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Current Photo --}}
                            <div class="text-center mb-4">
                                @if ($client->picture)
                                    <img src="{{ asset('storage/' . $client->picture) }}"
                                        class="rounded-circle shadow-sm mb-2"
                                        style="width: 80px; height: 80px; object-fit: cover;"
                                        alt="{{ $client->name }}">
                                @else
                                    <div class="mx-auto bg-gradient-info rounded-circle shadow-sm d-flex align-items-center justify-content-center mb-2"
                                        style="width: 80px; height: 80px;">
                                        <span class="text-white font-weight-bold text-lg">
                                            {{ strtoupper(substr($client->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                                <p class="text-sm text-secondary mb-0">{{ $client->email }}</p>
                                <span class="badge bg-gradient-{{ $client->is_active ? 'success' : 'warning' }} mt-1">
                                    {{ $client->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">New Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                                    <small class="text-muted">Only fill if changing password.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone_number) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold text-uppercase">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $client->address) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Profile Picture</label>
                                    <input type="file" name="picture" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                    <small class="text-muted">Max 2MB. Leave empty to keep current.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Account Status</label>
                                    <select name="is_active" class="form-control">
                                        <option value="1" {{ $client->is_active ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$client->is_active ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">
                                    <i class="fas fa-save me-1"></i> Update Client
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
