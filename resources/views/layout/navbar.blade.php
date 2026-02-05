<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">

        {{-- BREADCRUMB --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $title }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ $title }}</h6>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            {{-- SEARCH BAR --}}
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div>

            {{-- RIGHT MENU --}}
            <ul class="navbar-nav justify-content-end">
                @auth
                    <li class="nav-item d-flex align-items-center">
                        <div class="dropdown">
                            {{-- TRIGGER DROPDOWN (AVATAR & NAMA) --}}
                            <a href="#"
                                class="nav-link text-body font-weight-bold px-0 d-flex align-items-center gap-2"
                                id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                                {{-- LOGIKA: Tampilkan Gambar jika ada, jika tidak tampilkan Ikon --}}
                                @if (Auth::user()->picture)
                                    <img src="{{ asset('storage/' . Auth::user()->picture) }}"
                                        class="avatar avatar-sm rounded-circle shadow-sm"
                                        style="object-fit: cover; width: 36px; height: 36px;">
                                @else
                                    <div class="avatar avatar-sm bg-gradient-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px;">
                                        <i class="fa fa-user text-white text-sm"></i>
                                    </div>
                                @endif

                                {{-- Nama & Role (Hanya tampil di layar desktop) --}}
                                <div class="d-sm-flex d-none flex-column align-items-start ms-1" style="line-height: 1.2;">
                                    <span class="font-weight-bolder text-dark text-sm">{{ Auth::user()->name }}</span>
                                    <span
                                        class="text-xs text-secondary font-weight-bold">{{ ucfirst(Auth::user()->role) }}</span>
                                </div>
                            </a>

                            {{-- DROPDOWN MENU --}}
                            <ul class="dropdown-menu dropdown-menu-end px-2 py-3 shadow-lg border-0"
                                aria-labelledby="userDropdown">
                                {{-- Menu Profile --}}
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="{{ route('profile') }}">
                                        <div class="d-flex py-1 align-items-center">
                                            <div
                                                class="icon icon-shape icon-sm bg-gradient-info shadow text-center me-2 rounded-2">
                                                <i class="fa fa-user-edit text-white text-xs opacity-10"></i>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-0">
                                                    <span class="font-weight-bold">Edit Profile</span>
                                                </h6>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>

                                {{-- Menu Logout --}}
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                        @csrf
                                        <button type="submit" class="dropdown-item border-radius-md text-danger"
                                            onclick="return confirm('Are you sure you want to logout?')">
                                            <div class="d-flex py-1 align-items-center">
                                                <div
                                                    class="icon icon-shape icon-sm bg-gradient-danger shadow text-center me-2 rounded-2">
                                                    <i class="fa fa-sign-out-alt text-white text-xs opacity-10"></i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="text-sm font-weight-bold mb-0">Logout</h6>
                                                </div>
                                            </div>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="nav-item d-flex align-items-center">
                        <a href="{{ route('login') }}" class="nav-link text-body font-weight-bold px-0">
                            <i class="fas fa-key opacity-6 text-dark me-1"></i>
                            <span class="d-sm-inline d-none">Sign In</span>
                        </a>
                    </li>
                @endauth

                {{-- SIDEBAR TOGGLER (MOBILE) --}}
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>

                {{-- SETTINGS ICON --}}
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>

                {{-- NOTIFICATIONS --}}
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('layout/assets/img/team-2.jpg') }}"
                                            class="avatar avatar-sm me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New Message</span>
                                            from System
                                        </h6>
                                        <p class="text-xs text-secondary mb-0 ">
                                            <i class="fa fa-clock me-1"></i>
                                            Just now
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
