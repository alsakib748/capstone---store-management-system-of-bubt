@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Damage Product Details</h3>
                    <div class="text-end my-2 mt-md-0"><a class="btn btn-outline-primary"
                            href="{{ route('all.damage.product') }}">Back</a></div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- Damage Product info --}}
                            <div class="col-md-12 mb-4">
                                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; transition: 0.2s">
                                    <div class="card-header text-white text-center"
                                        style="background: linear-gradient(135deg, #dc3545, #c82333); border-radius:10px 10px 0 0;">
                                        <h5 class="mb-0 fw-bold">Damage Product Information</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Date:</strong>
                                            <span>{{ $damageProduct->date }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Tracking No:</strong>
                                            <span>{{ $damageProduct->tracking_no ?: '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Note No:</strong>
                                            <span>{{ $damageProduct->note_no ?: '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Semester:</strong>
                                            <span>{{ $damageProduct->semester ? (($damageProduct->semester->code ? $damageProduct->semester->code . ' : ' : '') . $damageProduct->semester->name) : '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Note:</strong>
                                            <span>{{ $damageProduct->note ?? $damageProduct->notes ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Damage Product info --}}

                            {{-- Order Summary  --}}
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card shadow-sm border-0 h-100"
                                            style="border-radius: 10px; transition: 0.2s">
                                            <div class="card-header text-white text-center"
                                                style="background: linear-gradient(135deg, #dc3545, #c82333); border-radius:10px 10px 0 0;">
                                                <h5 class="mb-0 fw-bold">Damaged Items</h5>
                                            </div>

                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Product Code</th>
                                                            <th>Product Name</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($damageProduct->damageProductItem as $key => $item)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $item->product->code }}</td>
                                                                <td>{{ $item->product->name }}</td>
                                                                <td>{{ $item->quantity ?? $item->qty }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
    </div>
@endsection
