@extends('layout.master')

@section('title', 'User Management')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
    <div class="container-fluid py-4">

        {{-- Header Section: Title, Search, & Button --}}
        <div class="row align-items-center mb-4">
            <div class="col-lg-6 col-7">
                <h4 class="font-weight-bolder text-white mb-0">User Management</h4>
                <p class="text-white opacity-8 text-sm">Manage access, approve couriers, and handle roles.</p>
            </div>
            <div class="col-lg-6 col-5 text-end">
                <div class="d-flex justify-content-end align-items-center gap-3">
                    {{-- Search Form --}}
                    <form action="{{ route('users.index') }}" method="GET" class="d-none d-md-flex me-2">
                        <div class="input-group">
                            <span class="input-group-text text-body bg-white border-end-0">
                                <i class="fas fa-search" aria-hidden="true"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="Search user..." value="{{ request('search') }}">
                        </div>
                    </form>

                    {{-- Add Button --}}
                    <a href="{{ route('users.create') }}" class="btn bg-white text-primary mb-0 shadow-sm">
                        <i class="fas fa-user-plus me-1"></i> Add User
                    </a>
                </div>
            </div>
        </div>

        {{-- User Table Card --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 border-0 shadow-lg">
                    <div class="card-header pb-0">
                        <h6>Users Table</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            User / Email</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Role</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Account Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Joined Date</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr class="hover-row">
                                            {{-- User Info --}}
                                            <td>
                                                <div class="d-flex px-3 py-1">
                                                    <div>
                                                        @if ($user->picture)
                                                            <img src="{{ asset('storage/' . $user->picture) }}"
                                                                class="avatar avatar me-3 rounded-circle shadow-sm"
                                                                alt="{{ $user->name }}"
                                                                style="object-fit: cover; width: 48px; height: 48px;">
                                                        @else
                                                            <div class="avatar avatar me-3 bg-gradient-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                                                style="width: 48px; height: 48px;">
                                                                <span class="text-white font-weight-bold text-sm">
                                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm font-weight-bold">{{ $user->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Role Badge --}}
                                            <td>
                                                @php
                                                    $badges = [
                                                        'owner' => ['color' => 'dark', 'icon' => 'fa-crown'],
                                                        'admin' => ['color' => 'primary', 'icon' => 'fa-user-shield'],
                                                        'courier' => ['color' => 'info', 'icon' => 'fa-truck'],
                                                        'customer' => ['color' => 'secondary', 'icon' => 'fa-user'],
                                                    ];
                                                    $roleData = $badges[$user->role] ?? [
                                                        'color' => 'secondary',
                                                        'icon' => 'fa-user',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge badge-sm bg-gradient-{{ $roleData['color'] }} px-3 py-2 text-xxs border-radius-md">
                                                    <i class="fas {{ $roleData['icon'] }} me-1"></i>
                                                    {{ strtoupper($user->role) }}
                                                </span>
                                            </td>

                                            {{-- Status & Contact Info --}}
                                            <td class="align-middle text-center">
                                                {{-- Logic Badge Status --}}
                                                @if ($user->is_active)
                                                    <span class="badge badge-sm bg-gradient-success">Active</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-warning">Pending Approval</span>
                                                @endif

                                                <div class="mt-2">
                                                    @if ($user->phone_number)
                                                        <p class="text-xs font-weight-bold mb-0 text-dark">
                                                            {{ $user->phone_number }}
                                                        </p>
                                                    @else
                                                        <span class="text-xs text-secondary">No Phone</span>
                                                    @endif

                                                    <p class="text-xs text-secondary mb-0 text-truncate mx-auto"
                                                        style="max-width: 150px;" title="{{ $user->address }}">
                                                        {{ $user->address ?? '-' }}
                                                    </p>
                                                </div>
                                            </td>

                                            {{-- Joined Date --}}
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    {{ $user->created_at->format('d M Y') }}
                                                </span>
                                            </td>

                                            {{-- Actions --}}
                                            <td class="align-middle text-end px-4">

                                                {{-- TOMBOL APPROVE (Hanya muncul jika user belum aktif) --}}
                                                @if (!$user->is_active)
                                                    <form action="{{ route('users.update', $user->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        {{-- Kirim is_active = 1 --}}
                                                        <input type="hidden" name="is_active" value="1">

                                                        {{-- Hidden Fields agar lolos validasi Controller --}}
                                                        <input type="hidden" name="name" value="{{ $user->name }}">
                                                        <input type="hidden" name="email" value="{{ $user->email }}">
                                                        <input type="hidden" name="role" value="{{ $user->role }}">

                                                        <button type="submit"
                                                            class="btn btn-link text-success text-gradient p-0 m-0 me-2"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Approve User">
                                                            <i class="fas fa-check-circle text-lg"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Edit Button --}}
                                                <a href="{{ route('users.edit', $user->id) }}" class="mx-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User">
                                                    <i class="fas fa-user-edit text-secondary text-sm"
                                                        aria-hidden="true"></i>
                                                </a>

                                                {{-- Delete Button --}}
                                                @if (auth()->id() !== $user->id)
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-link text-danger text-gradient p-0 m-0 border-0"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Delete / Reject User">
                                                            <i class="far fa-trash-alt text-sm" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center justify-content-center">
                                                    <i class="fas fa-users-slash fa-3x text-secondary opacity-5 mb-3"></i>
                                                    <h6 class="text-secondary">No users found</h6>
                                                    <p class="text-xs text-secondary">Try adjusting your search or add a
                                                        new
                                                        user.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Pagination --}}
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-end py-3">
                        {{ $users->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script for Tooltips --}}
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    <style>
        /* Hover Effect for Table Rows */
        .hover-row:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        /* Input Group Styling */
        .input-group-text {
            transition: all 0.2s ease;
        }

        .input-group:focus-within .input-group-text {
            border-color: #5e72e4;
            color: #5e72e4;
        }

        .input-group:focus-within .form-control {
            border-color: #5e72e4;
            box-shadow: none;
        }
    </style>
@endsection
