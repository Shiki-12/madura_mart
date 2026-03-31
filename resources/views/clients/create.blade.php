@extends('layout.master')

@section('title', 'Add New Client')

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
                                <h5 class="font-weight-bolder">Add New Client</h5>
                                <p class="text-sm text-secondary mb-0">Create a new customer account.</p>
                            </div>
                            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary btn-sm mb-0">
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

                        <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter full name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@example.com" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="Min. 6 characters" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-xs font-weight-bold text-uppercase">Address</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Full address...">{{ old('address') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-xs font-weight-bold text-uppercase">Profile Picture</label>
                                <input type="file" name="picture" class="form-control" accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted">Max 2MB. Supported: JPG, PNG</small>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn bg-gradient-primary">
                                    <i class="fas fa-save me-1"></i> Save Client
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
