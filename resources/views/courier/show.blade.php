@extends('layout.master')

@section('title', 'Order Details')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">

        {{-- Flash --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            {{-- Order Info --}}
            <div class="col-lg-7 mb-4">
                <div class="card border-0 shadow-lg">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="font-weight-bolder mb-1">{{ $order->invoice_number }}</h5>
                                <p class="text-sm text-secondary mb-0">Order placed on {{ $order->order_date }}</p>
                            </div>
                            <a href="{{ route('courier.index') }}" class="btn btn-outline-secondary btn-sm mb-0">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Customer Info --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Customer</p>
                                <h6 class="text-sm mb-0">{{ $order->user->name ?? 'Guest Customer' }}</h6>
                                <p class="text-xs text-secondary">{{ $order->user->phone_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Delivery Address</p>
                                <p class="text-sm mb-0">{{ $order->delivery_address }}</p>
                            </div>
                        </div>

                        <hr class="horizontal dark">

                        {{-- Order Items --}}
                        <p class="text-xs text-uppercase font-weight-bold text-secondary mb-2">Order Items</p>
                        <div class="table-responsive">
                            <table class="table table-sm align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                        <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold">{{ $item->product_name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-xs">{{ $item->quantity }}</span>
                                            </td>
                                            <td class="text-end">
                                                <span class="text-xs font-weight-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end font-weight-bolder text-sm">Total</td>
                                        <td class="text-end font-weight-bolder text-sm text-success">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <hr class="horizontal dark">

                        {{-- Status Info --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Current Status</p>
                                @php
                                    $sc = [
                                        'processed' => 'primary',
                                        'shipped'   => 'info',
                                        'arrived'   => 'success',
                                        'completed' => 'success',
                                    ];
                                @endphp
                                <span class="badge bg-gradient-{{ $sc[$order->status] ?? 'secondary' }} px-3 py-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-uppercase font-weight-bold text-secondary mb-1">Payment</p>
                                <span class="badge bg-gradient-dark px-3 py-2">{{ strtoupper($order->payment_method) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Panel --}}
            <div class="col-lg-5 mb-4">
                <div class="card border-0 shadow-lg">
                    <div class="card-header pb-0">
                        <h6><i class="fas fa-cogs me-2"></i>Update Delivery Status</h6>
                        <p class="text-sm text-secondary">Update this order's delivery status and upload proof.</p>
                    </div>
                    <div class="card-body">
                        @if ($order->status == 'completed')
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                                <h6 class="text-success">Order Completed</h6>
                                <p class="text-sm text-secondary">This order has been delivered and confirmed.</p>
                            </div>
                        @else
                            <form action="{{ route('courier.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Status --}}
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Status</label>
                                    <select name="status" class="form-control" required>
                                        @if ($order->status == 'processed')
                                            <option value="shipped">📦 Pick Up & Ship (In Transit)</option>
                                        @endif
                                        @if ($order->status == 'processed' || $order->status == 'shipped')
                                            <option value="arrived">📍 Mark as Arrived</option>
                                        @endif
                                    </select>
                                </div>

                                {{-- Expedition --}}
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Expedition (optional)</label>
                                    <select name="expedition_id" class="form-control">
                                        <option value="">— Self Delivery —</option>
                                        @foreach ($expeditions as $exp)
                                            <option value="{{ $exp->id }}"
                                                {{ ($delivery && $delivery->expedition_id == $exp->id) ? 'selected' : '' }}>
                                                {{ $exp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Proof Photo --}}
                                <div class="mb-3">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Proof of Delivery Photo</label>
                                    <input type="file" name="picture_proof" class="form-control" accept="image/*">
                                    <small class="text-muted">Upload a photo as proof of delivery. Max 4MB.</small>

                                    @if ($delivery && $delivery->picture_proof)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $delivery->picture_proof) }}"
                                                class="rounded shadow-sm" style="max-height: 120px;">
                                            <p class="text-xs text-success mt-1"><i class="fas fa-check me-1"></i>Proof uploaded</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Notes --}}
                                <div class="mb-4">
                                    <label class="form-label text-xs font-weight-bold text-uppercase">Notes</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Any delivery notes...">{{ $delivery->notes ?? '' }}</textarea>
                                </div>

                                <button type="submit" class="btn bg-gradient-primary w-100">
                                    <i class="fas fa-paper-plane me-1"></i> Update Delivery
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
