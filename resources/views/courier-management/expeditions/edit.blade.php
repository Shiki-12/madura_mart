@extends('layout.master')

@section('title', 'Edit Expedition')

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
                                <h5 class="font-weight-bolder">Edit Expedition</h5>
                                <p class="text-sm text-secondary mb-0">Update logistics partner information.</p>
                            </div>
                            <a href="{{ route('courier-management.index', ['tab' => 'expeditions']) }}" class="btn btn-outline-secondary btn-sm mb-0">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
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

                        <form action="{{ route('expeditions.update', $expedition->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Current Logo --}}
                            <div class="text-center mb-4">
                                @if ($expedition->picture)
                                    <img src="{{ asset('storage/' . $expedition->picture) }}"
                                        class="rounded shadow-sm mb-2 admin-edit-avatar">
                                @else
                                    <div class="mx-auto bg-gradient-dark rounded shadow-sm d-flex align-items-center justify-content-center mb-2 admin-edit-avatar-placeholder">
                                        <i class="fas fa-truck text-white text-xl"></i>
                                    </div>
                                @endif
                                <p class="text-sm font-weight-bold mb-0">{{ $expedition->name }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $expedition->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $expedition->phone_number) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold text-uppercase">Address <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="3" required>{{ old('address', $expedition->address) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-xs font-weight-bold text-uppercase">Company Logo / Picture</label>
                                <input type="file" name="picture" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted">Max 2MB. Leave empty to keep current image.</small>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('courier-management.index', ['tab' => 'expeditions']) }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">
                                    <i class="fas fa-save me-1"></i> Update Expedition
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
