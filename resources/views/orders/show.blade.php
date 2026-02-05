@extends('layout.master')

@section('title', 'Order Details')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">

        {{-- KIRI: Detail Barang --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white pb-0">
                    <h6>Order Items (Invoice: {{ $order->invoice_number }})</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                    <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                @if($item->product && $item->product->picture)
                                                    <img src="{{ asset('storage/' . $item->product->picture) }}" class="avatar avatar-sm me-3">
                                                @else
                                                    <div class="avatar avatar-sm bg-gradient-secondary me-3"></div>
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->product_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        x{{ $item->quantity }}
                                    </td>
                                    <td class="align-middle text-end text-sm font-weight-bold">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                                <tr class="border-top">
                                    <td colspan="3" class="text-end text-sm font-weight-bolder">TOTAL AMOUNT</td>
                                    <td class="text-end text-lg font-weight-bolder text-primary">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: Kontrol Admin --}}
        <div class="col-lg-4">

            {{-- Form Update Status & Kurir --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-gradient-dark">
                    <h6 class="text-white mb-0">Admin Actions</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Update Status --}}
                        <div class="mb-3">
                            <label class="form-label">Order Status</label>
                            <select name="status" class="form-select">
                                @php
                                    $statuses = ['pending', 'payment_verified', 'processed', 'shipped', 'arrived', 'completed', 'cancelled'];
                                @endphp
                                @foreach($statuses as $st)
                                    <option value="{{ $st }}" {{ $order->status == $st ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $st)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Assign Courier (Hanya muncul jika bukan cancelled/completed) --}}
                        <div class="mb-3">
                            <label class="form-label">Assign Courier</label>
                            <select name="courier_id" class="form-select">
                                <option value="">-- Select Courier --</option>
                                @foreach($couriers as $courier)
                                    <option value="{{ $courier->id }}" {{ $order->courier_id == $courier->id ? 'selected' : '' }}>
                                        {{ $courier->name }} ({{ $courier->phone_number ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted text-xs">Selecting a courier will update status to 'Processed' if it's currently pending.</small>
                        </div>

                        <button type="submit" class="btn bg-gradient-primary w-100 mb-0">Update Order</button>
                    </form>
                </div>
            </div>

            {{-- Info Pengiriman --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white pb-0">
                    <h6>Delivery Info</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">Customer:</strong> &nbsp; {{ $order->user->name ?? 'Guest' }}
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">Phone:</strong> &nbsp; {{ $order->user->phone_number ?? '-' }}
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">Address:</strong> <br>
                            <span class="text-secondary">{{ $order->delivery_address }}</span>
                        </li>
                        <li class="list-group-item border-0 ps-0 text-sm">
                            <strong class="text-dark">Payment Method:</strong> &nbsp;
                            <span class="badge bg-gradient-info">{{ strtoupper($order->payment_method) }}</span>
                        </li>
                    </ul>

                    {{-- Bukti Transfer (Jika Ada) --}}
                    @if($order->payment_proof)
                        <hr class="horizontal dark">
                        <h6 class="text-sm">Payment Proof</h6>
                        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="img-fluid border-radius-lg shadow-sm" alt="Proof">
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
