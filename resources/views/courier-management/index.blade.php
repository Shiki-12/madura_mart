@extends('layout.master')

@section('title', 'Courier Management')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="row align-items-center mb-4">
            <div class="col-lg-6 col-7">
                <h4 class="font-weight-bolder text-dark mb-0">Courier Management</h4>
                <p class="text-secondary text-sm">Oversee couriers, expeditions, and delivery tracking.</p>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold text-secondary">Total Couriers</p>
                                <h5 class="font-weight-bolder mb-0">{{ $totalCouriers }}</h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fas fa-motorcycle text-lg text-white opacity-10"></i>
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
                                <p class="text-sm mb-0 font-weight-bold text-secondary">Active Couriers</p>
                                <h5 class="font-weight-bolder mb-0 text-success">{{ $activeCouriers }}</h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fas fa-user-check text-lg text-white opacity-10"></i>
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
                                <p class="text-sm mb-0 font-weight-bold text-secondary">Pending Approval</p>
                                <h5 class="font-weight-bolder mb-0 text-warning">{{ $pendingCouriers }}</h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                    <i class="fas fa-user-clock text-lg text-white opacity-10"></i>
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
                                <p class="text-sm mb-0 font-weight-bold text-secondary">Total Deliveries</p>
                                <h5 class="font-weight-bolder mb-0 text-info">{{ $totalDeliveries }}</h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="fas fa-box text-lg text-white opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="card border-0 shadow-lg">
            <div class="card-header pb-0">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $tab == 'couriers' ? 'active' : '' }}" href="?tab=couriers">
                            <i class="fas fa-motorcycle me-1"></i> Couriers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tab == 'expeditions' ? 'active' : '' }}" href="?tab=expeditions">
                            <i class="fas fa-truck me-1"></i> Expeditions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tab == 'deliveries' ? 'active' : '' }}" href="?tab=deliveries">
                            <i class="fas fa-box me-1"></i> Deliveries
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body px-0 pt-0 pb-2">

                {{-- ============ COURIERS TAB ============ --}}
                @if ($tab == 'couriers')
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Courier</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Joined</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="12%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($couriers as $courier)
                                    <tr class="hover-row">
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    @if ($courier->picture)
                                                        <img src="{{ asset('storage/' . $courier->picture) }}"
                                                            class="avatar me-3 rounded-circle shadow-sm"
                                                            style="object-fit: cover; width: 48px; height: 48px;">
                                                    @else
                                                        <div class="avatar me-3 bg-gradient-info rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                                            style="width: 48px; height: 48px;">
                                                            <span class="text-white font-weight-bold text-sm">{{ strtoupper(substr($courier->name, 0, 1)) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm font-weight-bold">{{ $courier->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $courier->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-xs font-weight-bold">{{ $courier->phone_number ?? '-' }}</span></td>
                                        <td class="align-middle text-center">
                                            @if ($courier->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Active</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $courier->created_at->format('d M Y') }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                {{-- Toggle Active --}}
                                                <form action="{{ route('courier-management.update', $courier->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="is_active" value="{{ $courier->is_active ? 0 : 1 }}">
                                                    <button type="submit" class="btn btn-link p-0 mb-0" data-bs-toggle="tooltip"
                                                        title="{{ $courier->is_active ? 'Deactivate' : 'Approve / Activate' }}">
                                                        <i class="fas {{ $courier->is_active ? 'fa-toggle-on text-success' : 'fa-check-circle text-info' }} text-lg"></i>
                                                    </button>
                                                </form>

                                                {{-- Delete --}}
                                                <form action="{{ route('courier-management.destroy', $courier->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this courier?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 mb-0 border-0">
                                                        <i class="far fa-trash-alt text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-motorcycle fa-3x text-secondary opacity-5 mb-3"></i>
                                            <h6 class="text-secondary">No couriers registered</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- ============ EXPEDITIONS TAB ============ --}}
                @if ($tab == 'expeditions')
                    <div class="px-4 pt-3 pb-0 d-flex justify-content-end">
                        <a href="{{ route('expeditions.create') }}" class="btn bg-gradient-primary btn-sm mb-0">
                            <i class="fas fa-plus me-1"></i> Add Expedition
                        </a>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Expedition</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Address</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deliveries</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="12%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expeditions as $exp)
                                    <tr class="hover-row">
                                        <td>
                                            <div class="d-flex px-3 py-1 align-items-center">
                                                @if ($exp->picture)
                                                    <img src="{{ asset('storage/' . $exp->picture) }}"
                                                        class="avatar me-3 rounded shadow-sm"
                                                        style="object-fit: cover; width: 40px; height: 40px;">
                                                @else
                                                    <div class="avatar me-3 bg-gradient-primary rounded shadow-sm d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="fas fa-truck text-white text-sm"></i>
                                                    </div>
                                                @endif
                                                <h6 class="mb-0 text-sm font-weight-bold">{{ $exp->name }}</h6>
                                            </div>
                                        </td>
                                        <td><span class="text-xs text-secondary">{{ Str::limit($exp->address, 40) }}</span></td>
                                        <td><span class="text-xs font-weight-bold">{{ $exp->phone_number }}</span></td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-sm bg-gradient-info">{{ $exp->deliveries_count }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{ route('expeditions.edit', $exp->id) }}" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-pen text-secondary text-sm"></i>
                                                </a>
                                                <form action="{{ route('expeditions.destroy', $exp->id) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this expedition?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 mb-0 border-0">
                                                        <i class="far fa-trash-alt text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-truck fa-3x text-secondary opacity-5 mb-3"></i>
                                            <h6 class="text-secondary">No expeditions registered</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- ============ DELIVERIES TAB ============ --}}
                @if ($tab == 'deliveries')
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Order</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Courier</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Expedition</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Proof</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deliveries as $delivery)
                                    <tr class="hover-row">
                                        <td class="ps-3">
                                            <span class="text-xs font-weight-bold text-dark">
                                                {{ $delivery->order->invoice_number ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold">{{ $delivery->courier->name ?? 'Unassigned' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-xs text-secondary">{{ $delivery->expedition->name ?? '-' }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            @php
                                                $statusColors = [
                                                    'assigned'   => 'secondary',
                                                    'picked_up'  => 'info',
                                                    'in_transit' => 'primary',
                                                    'delivered'  => 'success',
                                                    'failed'     => 'danger',
                                                ];
                                            @endphp
                                            <span class="badge badge-sm bg-gradient-{{ $statusColors[$delivery->status] ?? 'secondary' }}">
                                                {{ ucfirst(str_replace('_', ' ', $delivery->status ?? 'assigned')) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-xs text-secondary">{{ $delivery->delivery_date?->format('d M Y') ?? '-' }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($delivery->picture_proof)
                                                <a href="{{ asset('storage/' . $delivery->picture_proof) }}" target="_blank" class="btn btn-link p-0 mb-0">
                                                    <i class="fas fa-image text-info"></i>
                                                </a>
                                            @else
                                                <span class="text-xs text-secondary">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fas fa-box-open fa-3x text-secondary opacity-5 mb-3"></i>
                                            <h6 class="text-secondary">No delivery records yet</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($deliveries->hasPages())
                        <div class="card-footer border-0 d-flex justify-content-center pt-3 pb-3">
                            {{ $deliveries->withQueryString()->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <style>
        .hover-row:hover { background-color: #f8f9fa; transition: background-color 0.3s ease; }
    </style>
@endsection

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(t) { return new bootstrap.Tooltip(t) })
</script>
@endsection
