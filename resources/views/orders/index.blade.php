@extends('layout.master')

@section('title', 'Order')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 border-0 shadow-lg">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>Incoming Orders</h6>
                    {{-- Filter Status (Nanti bisa dikembangkan) --}}
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Invoice / Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total & Payment</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status / Courier</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr class="hover-row">
                                        {{-- Invoice --}}
                                        <td>
                                            <div class="d-flex px-3 py-1 flex-column">
                                                <h6 class="mb-0 text-sm text-primary font-weight-bold">{{ $order->invoice_number }}</h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, H:i') }}
                                                </p>
                                            </div>
                                        </td>

                                        {{-- Customer --}}
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $order->user->name ?? 'Guest / Deleted' }}</p>
                                            <p class="text-xs text-secondary mb-0 text-truncate" style="max-width: 150px;">
                                                {{ $order->delivery_address }}
                                            </p>
                                        </td>

                                        {{-- Total --}}
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 text-success">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </p>
                                            <span class="text-xs text-secondary">{{ strtoupper($order->payment_method) }}</span>
                                        </td>

                                        {{-- Status --}}
                                        <td class="align-middle text-center">
                                            @php
                                                $statusColor = [
                                                    'pending' => 'secondary',
                                                    'payment_verified' => 'info',
                                                    'processed' => 'warning',
                                                    'shipped' => 'primary',
                                                    'arrived' => 'info',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                            @endphp
                                            <span class="badge badge-sm bg-gradient-{{ $statusColor[$order->status] ?? 'secondary' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>

                                            <div class="mt-1">
                                                @if($order->courier)
                                                    <small class="text-xs font-weight-bold text-dark">
                                                        <i class="fas fa-truck me-1"></i> {{ $order->courier->name }}
                                                    </small>
                                                @else
                                                    <small class="text-xs text-secondary fst-italic">No Courier</small>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Action --}}
                                        <td class="align-middle text-end px-4">
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm bg-gradient-dark mb-0">
                                                Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-secondary">
                                            <i class="fas fa-shopping-basket fa-3x mb-3 opacity-5"></i>
                                            <h6>No orders found yet</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
