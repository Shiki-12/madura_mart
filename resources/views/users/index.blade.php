@extends('layout.master')

@section('title', 'User Management')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-white font-weight-bolder">User Management</h4>
        <a href="{{ route('users.create') }}" class="btn bg-white text-primary">
            <i class="fas fa-user-plus me-1"></i> Add New User
        </a>
    </div>

    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone / Address</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Joined</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @if($user->picture)
                                                <img src="{{ asset('storage/' . $user->picture) }}" class="avatar avatar-sm me-3" alt="user1">
                                            @else
                                                <div class="avatar avatar-sm me-3 bg-gradient-primary">{{ substr($user->name, 0, 1) }}</div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $badges = [
                                            'owner' => 'bg-gradient-dark',
                                            'admin' => 'bg-gradient-primary',
                                            'courier' => 'bg-gradient-info',
                                            'customer' => 'bg-gradient-secondary'
                                        ];
                                    @endphp
                                    <span class="badge badge-sm {{ $badges[$user->role] ?? 'bg-secondary' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $user->phone_number ?? '-' }}</p>
                                    <p class="text-xs text-secondary mb-0 text-truncate" style="max-width: 150px;">
                                        {{ $user->address ?? '-' }}
                                    </p>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('users.edit', $user->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-xs p-0 m-0 align-baseline font-weight-bold">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection 