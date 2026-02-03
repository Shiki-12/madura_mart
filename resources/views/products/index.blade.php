@extends('layout.master')

@section('title', 'Products')

@section('menu')
    @include('layout.menu')
@endsection

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 font-weight-bold mb-0">Products</h2>
            <p class="text-muted small mb-0">Manage your product catalog and inventory</p>
        </div>
        <div>
            <a href="#" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-plus me-1"></i> Add New Product
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 bg-light" placeholder="Search product name, SKU...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm bg-light">
                        <option selected>All Categories</option>
                        <option value="1">Food & Snacks</option>
                        <option value="2">Beverages</option>
                        <option value="3">Daily Essentials</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-select-sm bg-light">
                        <option selected>All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">#</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product Details</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 text-secondary text-xs font-weight-bold">1</td>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="https://placehold.co/100x100/purple/white?text=Coffee" class="avatar avatar-sm me-3 rounded" alt="prod1" style="width: 40px; height: 40px; object-fit: cover;">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm font-weight-bold">Kapal Api Coffee (Sachet)</h6>
                                        <p class="text-xs text-secondary mb-0">SKU: KKA-001</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-xs font-weight-bold text-secondary">Beverages</span></td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">Rp 12,500</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge bg-warning text-dark text-xs">45 Pcs</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge bg-success text-xs">Active</span>
                            </td>
                            <td class="align-middle text-center">
                                <a href="#" class="text-secondary font-weight-bold text-xs me-2" data-bs-toggle="tooltip" title="Edit product">
                                    <i class="fas fa-edit text-info"></i>
                                </a>
                                <a href="#" class="text-secondary font-weight-bold text-xs" data-bs-toggle="tooltip" title="Delete product">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4 text-secondary text-xs font-weight-bold">2</td>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="https://placehold.co/100x100/orange/white?text=Noodle" class="avatar avatar-sm me-3 rounded" alt="prod2" style="width: 40px; height: 40px; object-fit: cover;">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm font-weight-bold">Indomie Goreng Original</h6>
                                        <p class="text-xs text-secondary mb-0">SKU: IND-G01</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-xs font-weight-bold text-secondary">Food & Snacks</span></td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">Rp 3,100</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge bg-info text-dark text-xs">1,200 Pcs</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge bg-success text-xs">Active</span>
                            </td>
                            <td class="align-middle text-center">
                                <a href="#" class="text-secondary font-weight-bold text-xs me-2">
                                    <i class="fas fa-edit text-info"></i>
                                </a>
                                <a href="#" class="text-secondary font-weight-bold text-xs">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4 text-secondary text-xs font-weight-bold">3</td>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="https://placehold.co/100x100/grey/white?text=Sugar" class="avatar avatar-sm me-3 rounded" alt="prod3" style="width: 40px; height: 40px; object-fit: cover;">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm font-weight-bold">White Sugar 1kg</h6>
                                        <p class="text-xs text-secondary mb-0">SKU: GLP-100</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="text-xs font-weight-bold text-secondary">Daily Essentials</span></td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">Rp 14,000</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge bg-danger text-xs">0 Pcs</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge bg-secondary text-xs">Inactive</span>
                            </td>
                            <td class="align-middle text-center">
                                <a href="#" class="text-secondary font-weight-bold text-xs me-2">
                                    <i class="fas fa-edit text-info"></i>
                                </a>
                                <a href="#" class="text-secondary font-weight-bold text-xs">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-top-0 d-flex justify-content-end py-3">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
