@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                </div>
            </div>

            <!-- start row - Main Stats -->
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="row g-3">

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #0066cc 0%, #003366 100%);">
                                                <i data-feather="box" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Total Products</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalProducts }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);">
                                                <i data-feather="users" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Total Users</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalUsers }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);">
                                                <i data-feather="truck" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Suppliers</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalSuppliers }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Second Row - Purchase & Sales -->
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="row g-3">

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #e0a800 0%, #b38600 100%);">
                                                <i data-feather="shopping-cart" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Total Purchase</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalPurchase }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
                                                <i data-feather="file-text" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Requisitions</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalRequisitions }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #20c997 0%, #17a275 100%);">
                                                <i data-feather="send" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Issues</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalIssues }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Third Row - Inventory Management -->
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="row g-3">

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);">
                                                <i data-feather="alert-triangle" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Damage Products</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalDamageProducts }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);">
                                                <i data-feather="grid" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Categories</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalCategories }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #f8258a 0%, #c01c6d 100%);">
                                                <i data-feather="tag" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Brands</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalBrands }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Fourth Row - Academic & Organization -->
            <div class="row">
                <div class="col-md-12 col-xl-12">
                    <div class="row g-3">

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #495057 0%, #343a40 100%);">
                                                <i data-feather="book" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Semesters</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalSemesters }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="d-flex align-items-center justify-content-center rounded-2"
                                                style="width: 48px; height: 48px; background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
                                                <i data-feather="briefcase" class="text-white"
                                                    style="height: 24px; width: 24px;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fs-14 mb-1">Departments</div>
                                            <div class="fs-20 mb-0 fw-semibold text-black">{{ $totalDepartments }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
