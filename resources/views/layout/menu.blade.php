<div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">

        {{-- ========================================================= --}}
        {{-- AREA UMUM (ADMIN & OWNER) --}}
        {{-- ========================================================= --}}

        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard*') || Request::is('/') ? 'active' : '' }}"
                href="{{ route('dashboard.index') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="{{ Request::is('dashboard*') || Request::is('/') ? 'white' : '#67748e' }}"
                        class="bi bi-menu-app-fill" viewBox="0 0 16 16">
                        <path
                            d="M0 1.5A1.5 1.5 0 0 1 1.5 0h2A1.5 1.5 0 0 1 5 1.5v2A1.5 1.5 0 0 1 3.5 5h-2A1.5 1.5 0 0 1 0 3.5zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5" />
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Dashboard</span>
            </a>
        </li>

        {{-- PRODUCTS --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="{{ Request::is('products*') ? 'white' : '#67748e' }}" viewBox="0 0 18 18">
                        <path
                            d="M11.25,5.5c-.414,0-.75-.336-.75-.75v-1.75c0-.827-.673-1.5-1.5-1.5s-1.5,.673-1.5,1.5v1.75c0,.414-.336,.75-.75,.75s-.75-.336-.75-.75v-1.75c0-1.654,1.346-3,3-3s3,1.346,3,3v1.75c0,.414-.336,.75-.75,.75Z">
                        </path>
                        <path
                            d="M15.406,6.512c-.125-1.432-1.302-2.512-2.739-2.512H5.333c-1.437,0-2.615,1.08-2.739,2.512l-.652,7.5c-.067,.766,.193,1.53,.712,2.097s1.258,.892,2.027,.892H13.318c.769,0,1.508-.325,2.027-.892s.779-1.331,.712-2.097l-.652-7.5Z">
                        </path>
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Products</span>
            </a>
        </li>

        {{-- CLIENTS --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('clients*') ? 'active' : '' }}" href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="{{ Request::is('clients*') ? 'white' : '#67748e' }}" class="bi bi-table"
                        viewBox="0 0 16 16">
                        <path
                            d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 2h-4v3h4zm0 4h-4v3h4zm0 4h-4v3h3a1 1 0 0 0 1-1zm-5 3v-3H6v3zm-5 0v-3H1v2a1 1 0 0 0 1 1zm-4-4h4V8H1zm0-4h4V4H1zm5-3v3h4V4zm4 4H6v3h4z" />
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Clients</span>
            </a>
        </li>

        {{-- PURCHASE --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('purchase*') ? 'active' : '' }}" href="{{ route('purchase.index') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)"
                                fill="{{ Request::is('purchase*') ? 'white' : '#67748e' }}" fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                    <g transform="translate(453.000000, 454.000000)">
                                        <path class="color-background opacity-6"
                                            d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z">
                                        </path>
                                        <path class="color-background"
                                            d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Purchase</span>
            </a>
        </li>

        {{-- ORDER --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('orders*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="{{ Request::is('orders*') ? 'white' : '#67748e' }}" class="bi bi-basket2-fill"
                        viewBox="0 0 16 16">
                        <path
                            d="M5.929 1.757a.5.5 0 1 0-.858-.514L2.217 6H.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h.623l1.844 6.456A.75.75 0 0 0 3.69 15h8.622a.75.75 0 0 0 .722-.544L14.877 8h.623a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1.717L10.93 1.243a.5.5 0 1 0-.858.514L12.617 6H3.383zM4 10a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm3 0a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0zm4-1a1 1 0 0 1 1 1v2a1 1 0 1 1-2 0v-2a1 1 0 0 1 1-1" />
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Order</span>
            </a>
        </li>

        {{-- SALE --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('sales*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="{{ Request::is('sales*') ? 'white' : '#67748e' }}" class="bi bi-cash-stack"
                        viewBox="0 0 16 16">
                        <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                        <path
                            d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z" />
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Sale</span>
            </a>
        </li>

        {{-- DISTRIBUTOR --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('distributors*') ? 'active' : '' }}"
                href="{{ route('distributors.index') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="{{ Request::is('distributors*') ? 'white' : '#67748e' }}" class="bi bi-truck"
                        viewBox="0 0 16 16">
                        <path
                            d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Distributor</span>
            </a>
        </li>

        {{-- COURIER --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('couriers*') ? 'active' : '' }}" href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="{{ Request::is('couriers*') ? 'white' : '#67748e' }}" class="bi bi-bicycle"
                        viewBox="0 0 16 16">
                        <path
                            d="M4 4.5a.5.5 0 0 1 .5-.5H6a.5.5 0 0 1 0 1v.5h4.14l.386-1.158A.5.5 0 0 1 11 4h1a.5.5 0 0 1 0 1h-.64l-.311.935.807 1.29a3 3 0 1 1-.848.53l-.508-.812-2.076 3.322A.5.5 0 0 1 8 10.5H5.959a3 3 0 1 1-1.815-3.274L5 5.856V5h-.5a.5.5 0 0 1-.5-.5m1.5 2.443-.508.814c.5.444.85 1.054.967 1.743h1.139zM8 9.057 9.598 6.5H6.402zM4.937 9.5a2 2 0 0 0-.487-.877l-.548.877zM3.603 8.092A2 2 0 1 0 4.937 10.5H3a.5.5 0 0 1-.424-.765zm7.947.53a2 2 0 1 0 .848-.53l1.026 1.643a.5.5 0 1 1-.848.53z" />
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Courier</span>
            </a>
        </li>


        {{-- ========================================================= --}}
        {{-- AREA PRIVASI OWNER (HANYA OWNER YANG BISA LIHAT) --}}
        {{-- ========================================================= --}}

        @if (auth()->user()->role == 'owner')
            {{-- USERS --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="{{ Request::is('users*') ? 'white' : '#67748e' }}" class="bi bi-person-fill"
                            viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
            </li>
        @endif


        {{-- ========================================================= --}}
        {{-- REPORTS (BISA ADMIN / OWNER - TERGANTUNG KEBIJAKAN) --}}
        {{-- ========================================================= --}}

        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">REPORTS</h6>
        </li>

        {{-- DISTRIBUTOR REPORTS --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('reports/distributor*') ? 'active' : '' }}" href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-1717.000000, -291.000000)"
                                fill="{{ Request::is('reports/distributor*') ? 'white' : '#67748e' }}"
                                fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                    <g transform="translate(1.000000, 0.000000)">
                                        <path class="color-background opacity-6"
                                            d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z">
                                        </path>
                                        <path class="color-background"
                                            d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z">
                                        </path>
                                        <path class="color-background"
                                            d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Distributor Reports</span>
            </a>
        </li>

        {{-- PRODUCT REPORTS --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('reports/product*') ? 'active' : '' }}" href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg width="12px" height="12px" viewBox="0 0 40 44" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-1870.000000, -591.000000)"
                                fill="{{ Request::is('reports/product*') ? 'white' : '#67748e' }}"
                                fill-rule="nonzero">
                                <g transform="translate(1716.000000, 291.000000)">
                                    <g transform="translate(154.000000, 300.000000)">
                                        <path class="color-background opacity-6"
                                            d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z">
                                        </path>
                                        <path class="color-background"
                                            d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Product Reports </span>
            </a>
        </li>

        {{-- ORDER REPORTS --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('reports/order*') ? 'active' : '' }}" href="#">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                        <defs>
                            <style>
                                .cls-1 {
                                    fill: {{ Request::is('reports/order*') ? 'white' : '#67748e' }}
                                }
                            </style>
                        </defs>
                        <g id="purchase">
                            <path class="cls-1"
                                d="M28.3 18H24v-3a3 3 0 0 0-6 0v3h-4.3a1.7 1.7 0 0 0-1.7 1.7v1.6a1.71 1.71 0 0 0 1.39 1.7l.18 1H4.29a.29.29 0 0 1-.29-.29V4.29A.29.29 0 0 1 4.29 4h15.42a.29.29 0 0 1 .29.29V9a1 1 0 0 0 2 0V4.29A2.3 2.3 0 0 0 19.71 2H4.29A2.3 2.3 0 0 0 2 4.29v19.42A2.3 2.3 0 0 0 4.29 26h9.63l.31 1.76A2.7 2.7 0 0 0 16.89 30H21a1 1 0 0 0 0-2h-4.11a.71.71 0 0 1-.69-.58L15.42 23h11.16l-.78 4.42a.71.71 0 0 1-.69.58 1 1 0 0 0 0 2 2.7 2.7 0 0 0 2.66-2.24l.84-4.76A1.71 1.71 0 0 0 30 21.3v-1.6a1.7 1.7 0 0 0-1.7-1.7zm-.3 2v1h-4v-1zm-14 0h4v1h-4zm6-5a1 1 0 0 1 2 0v6h-2z" />
                            <path class="cls-1"
                                d="M7 6a1 1 0 1 0 1 1 1 1 0 0 0-1-1zM17 6h-7a1 1 0 0 0 0 2h7a1 1 0 0 0 0-2zM7 10a1 1 0 1 0 1 1 1 1 0 0 0-1-1zM18 11a1 1 0 0 0-1-1h-7a1 1 0 0 0 0 2h7a1 1 0 0 0 1-1zM7 14a1 1 0 1 0 1 1 1 1 0 0 0-1-1zM10 14a1 1 0 0 0 0 2h5a1 1 0 0 0 0-2z" />
                        </g>
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Order Reports</span>
            </a>
        </li>

        {{-- SALE REPORTS --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('reports/sale*') ? 'active' : '' }}"
                href="{{ route('reports.sale') }}">
                <div
                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="57px" height="57px"
                        viewBox="0 0 18 18">
                        <rect x="12.5" y="2" width="4" height="14" rx="1.75" ry="1.75"
                            fill="{{ Request::is('reports/sale*') ? 'white' : '#67748e' }}"></rect>
                        <rect x="7" y="7" width="4" height="9" rx="1.75" ry="1.75"
                            fill="{{ Request::is('reports/sale*') ? 'white' : '#67748e' }}"></rect>
                        <rect x="1.5" y="11" width="4" height="5" rx="1.75" ry="1.75"
                            fill="{{ Request::is('reports/sale*') ? 'white' : '#67748e' }}"></rect>
                        <path
                            d="M2.75,9.5c.192,0,.384-.073,.53-.22l4.72-4.72v.689c0,.414,.336,.75,.75,.75s.75-.336,.75-.75V2.75c0-.414-.336-.75-.75-.75h-2.5c-.414,0-.75,.336-.75,.75s.336,.75,.75,.75h.689L2.22,8.22c-.293,.293-.293,.768,0,1.061,.146,.146,.338,.22,.53,.22Z"
                            fill="{{ Request::is('reports/sale*') ? 'white' : '#67748e' }}" data-color="color-2">
                        </path>
                    </svg>
                </div>
                <span class="nav-link-text ms-1">Sale Reports</span>
            </a>
        </li>
    </ul>
</div>
