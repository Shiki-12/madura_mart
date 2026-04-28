@extends('layout.master')

@section('title', 'Client Management')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="row align-items-center mb-4">
            <div class="col-lg-6 col-7">
                <h4 class="font-weight-bolder text-dark mb-0">Client Management</h4>
                <p class="text-secondary text-sm">Manage your registered customers and their accounts.</p>
            </div>
            <div class="col-lg-6 col-5 text-end">
                <div class="d-flex justify-content-end align-items-center gap-3">
                    {{-- Search --}}
                    <form action="{{ route('clients.index') }}" method="GET" class="d-none d-md-flex me-2">
                        <div class="input-group">
                            <span class="input-group-text text-body bg-white border-end-0">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="Search client..." value="{{ request('search') }}">
                        </div>
                    </form>
                    <a href="{{ route('clients.create') }}" class="btn bg-white text-primary mb-0 shadow-sm">
                        <i class="fas fa-user-plus me-1"></i> Add Client
                    </a>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <span class="alert-icon"><i class="fas fa-check-circle me-2"></i></span>
                <span class="alert-text">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Total Clients</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ \App\Models\User::where('role', 'customer')->count() }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fas fa-users text-lg text-white opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Active</p>
                                    <h5 class="font-weight-bolder mb-0 text-success">
                                        {{ \App\Models\User::where('role', 'customer')->where('is_active', 1)->count() }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fas fa-user-check text-lg text-white opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Inactive</p>
                                    <h5 class="font-weight-bolder mb-0 text-warning">
                                        {{ \App\Models\User::where('role', 'customer')->where('is_active', 0)->count() }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="fas fa-user-clock text-lg text-white opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">New This Month</p>
                                    <h5 class="font-weight-bolder mb-0 text-info">
                                        {{ \App\Models\User::where('role', 'customer')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count() }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="fas fa-user-plus text-lg text-white opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 border-0 shadow-lg">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Clients Table</h6>
                        {{-- Filter by Status --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('clients.index', request()->except('status')) }}"
                                class="btn btn-sm {{ !request()->has('status') ? 'bg-gradient-primary text-white' : 'btn-outline-secondary' }} mb-0">All</a>
                            <a href="{{ route('clients.index', array_merge(request()->all(), ['status' => 1])) }}"
                                class="btn btn-sm {{ request('status') === '1' ? 'bg-gradient-success text-white' : 'btn-outline-secondary' }} mb-0">Active</a>
                            <a href="{{ route('clients.index', array_merge(request()->all(), ['status' => 0])) }}"
                                class="btn btn-sm {{ request('status') === '0' ? 'bg-gradient-warning text-white' : 'btn-outline-secondary' }} mb-0">Inactive</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Client / Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Address</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Joined</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($clients as $client)
                                        <tr class="hover-row">
                                            <td>
                                                <div class="d-flex px-3 py-1">
                                                    <div>
                                                        @if ($client->picture)
                                                            <img src="{{ asset('storage/' . $client->picture) }}"
                                                                class="avatar me-3 rounded-circle shadow-sm mm-mobile-avatar"
                                                                alt="{{ $client->name }}">
                                                        @else
                                                            <div class="avatar me-3 bg-gradient-info rounded-circle shadow-sm d-flex align-items-center justify-content-center mm-mobile-avatar-placeholder">
                                                                <span class="text-white font-weight-bold text-sm">
                                                                    {{ strtoupper(substr($client->name, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm font-weight-bold">{{ $client->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $client->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold">{{ $client->phone_number ?? '-' }}</span>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary mb-0 text-truncate admin-address-truncate" title="{{ $client->address }}">
                                                    {{ $client->address ?? '-' }}
                                                </p>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if ($client->is_active)
                                                    <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-warning">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $client->created_at->format('d M Y') }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    {{-- Toggle Status --}}
                                                    <form action="{{ route('clients.update', $client->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="name" value="{{ $client->name }}">
                                                        <input type="hidden" name="email" value="{{ $client->email }}">
                                                        <input type="hidden" name="is_active" value="{{ $client->is_active ? 0 : 1 }}">
                                                        <button type="submit" class="btn btn-link p-0 mb-0"
                                                            data-bs-toggle="tooltip" title="{{ $client->is_active ? 'Deactivate' : 'Activate' }}">
                                                            <i class="fas {{ $client->is_active ? 'fa-toggle-on text-success' : 'fa-toggle-off text-secondary' }} text-lg"></i>
                                                        </button>
                                                    </form>

                                                    {{-- Edit --}}
                                                    <a href="{{ route('clients.edit', $client->id) }}"
                                                        data-bs-toggle="tooltip" title="Edit Client">
                                                        <i class="fas fa-user-edit text-secondary text-sm"></i>
                                                    </a>

                                                    {{-- Delete --}}
                                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this client?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger p-0 mb-0 border-0"
                                                            data-bs-toggle="tooltip" title="Delete Client">
                                                            <i class="far fa-trash-alt text-sm"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-users-slash fa-3x text-secondary opacity-5 mb-3"></i>
                                                    <h6 class="text-secondary">No clients found</h6>
                                                    <p class="text-xs text-secondary">Try adjusting your search or add a new client.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($clients->hasPages())
                        <div class="card-footer border-0 d-flex justify-content-center pt-3 pb-3">
                            {{ $clients->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(t) { return new bootstrap.Tooltip(t) })
</script>
@endsection
