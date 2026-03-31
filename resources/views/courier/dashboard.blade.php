@extends('layout.master')

@section('title', 'Courier Dashboard')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="row align-items-center mb-4">
            <div class="col-lg-8">
                <h4 class="font-weight-bolder text-dark mb-0">
                    <i class="fas fa-motorcycle me-2"></i>Courier Dashboard
                </h4>
                <p class="text-secondary text-sm">
                    Welcome back, <strong>{{ auth()->user()->name }}</strong>! Here are your assigned deliveries.
                </p>
            </div>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <p class="text-sm mb-0 font-weight-bold text-secondary">Active Orders</p>
                                <h5 class="font-weight-bolder mb-0 text-primary">{{ $stats['active'] }}</h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="fas fa-shipping-fast text-lg opacity-10"></i>
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
                                <p class="text-sm mb-0 font-weight-bold text-secondary">Arrived</p>
                                <h5 class="font-weight-bolder mb-0 text-info">{{ $stats['arrived'] }}</h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                    <i class="fas fa-map-marker-alt text-lg opacity-10"></i>
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
                                <p class="text-sm mb-0 font-weight-bold text-secondary">Completed</p>
                                <h5 class="font-weight-bolder mb-0 text-success">{{ $stats['completed'] }}</h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                    <i class="fas fa-check-double text-lg opacity-10"></i>
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
                                <p class="text-sm mb-0 font-weight-bold text-secondary">Total Assigned</p>
                                <h5 class="font-weight-bolder mb-0">{{ $stats['total'] }}</h5>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md">
                                    <i class="fas fa-clipboard-list text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Orders --}}
        <div class="card border-0 shadow-lg mb-4">
            <div class="card-header pb-0">
                <h6><i class="fas fa-box me-2"></i>Active Orders — Awaiting Action</h6>
                <p class="text-sm text-secondary">Orders assigned to you that need pickup or delivery confirmation.</p>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Invoice</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Address</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Items</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignedOrders as $order)
                                <tr class="hover-row">
                                    <td class="ps-3">
                                        <span class="text-sm font-weight-bold text-dark">{{ $order->invoice_number }}</span>
                                        <br><span class="text-xs text-secondary">{{ $order->order_date }}</span>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">{{ $order->user->name ?? 'Guest' }}</span>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0 text-truncate" style="max-width: 200px;" title="{{ $order->delivery_address }}">
                                            {{ $order->delivery_address }}
                                        </p>
                                    </td>
                                    <td class="align-middle text-center">
                                        @php
                                            $sc = [
                                                'processed' => 'primary',
                                                'shipped'   => 'info',
                                                'arrived'   => 'success',
                                            ];
                                        @endphp
                                        <span class="badge badge-sm bg-gradient-{{ $sc[$order->status] ?? 'secondary' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="badge badge-sm bg-gradient-dark">{{ $order->items->count() }}</span>
                                    </td>
                                    <td class="align-middle text-end px-4">
                                        <a href="{{ route('courier.show', $order->id) }}" class="btn bg-gradient-info btn-sm mb-0">
                                            <i class="fas fa-eye me-1"></i> View & Update
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-secondary opacity-5 mb-3"></i>
                                        <h6 class="text-secondary">No active orders assigned</h6>
                                        <p class="text-xs text-secondary">Check back later for new delivery assignments.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Recent Deliveries --}}
        @if ($deliveries->count() > 0)
            <div class="card border-0 shadow-lg">
                <div class="card-header pb-0">
                    <h6><i class="fas fa-history me-2"></i>Recent Delivery History</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Order</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Expedition</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deliveries as $delivery)
                                    <tr>
                                        <td class="ps-3"><span class="text-xs font-weight-bold">{{ $delivery->order->invoice_number ?? 'N/A' }}</span></td>
                                        <td><span class="text-xs text-secondary">{{ $delivery->expedition->name ?? '-' }}</span></td>
                                        <td class="text-center">
                                            <span class="badge badge-sm bg-gradient-{{ $delivery->status == 'delivered' ? 'success' : 'info' }}">
                                                {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-center"><span class="text-xs text-secondary">{{ $delivery->delivery_date?->format('d M Y') }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>.hover-row:hover { background-color: #f8f9fa; transition: background-color 0.3s ease; }</style>
@endsection
