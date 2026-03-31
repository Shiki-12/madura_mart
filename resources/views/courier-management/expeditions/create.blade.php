@extends('layout.master')

@section('title', 'Add Expedition')

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
                                <h5 class="font-weight-bolder">Add New Expedition</h5>
                                <p class="text-sm text-secondary mb-0">Register a logistics partner company.</p>
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

                        <form action="{{ route('expeditions.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. JNE Express" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}" placeholder="08xxxxxxxxxx" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold text-uppercase">Address <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-xs font-weight-bold text-uppercase">Company Logo / Picture</label>
                                <input type="file" name="picture" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted">Max 2MB. Supported: JPG, PNG</small>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('courier-management.index', ['tab' => 'expeditions']) }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">
                                    <i class="fas fa-save me-1"></i> Save Expedition
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
