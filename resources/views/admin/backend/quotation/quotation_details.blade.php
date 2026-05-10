@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Quotation Details</h3>
                    <div class="text-end my-2 mt-md-0">
                        <a class="btn btn-outline-primary" href="{{ route('all.quotation') }}">Back</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px;">
                                    <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0 0;">
                                        <h5 class="mb-0 fw-bold">Supplier Information</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Name:</strong>
                                            <span>{{ $quotation->supplier->name ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Email:</strong>
                                            <span>{{ $quotation->supplier->email ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px;">
                                    <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0 0;">
                                        <h5 class="mb-0 fw-bold">Quotation Information</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Quotation No:</strong>
                                            <span>{{ $quotation->quotation_no }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Date:</strong>
                                            <span>{{ \Carbon\Carbon::parse($quotation->quotation_date)->format('Y-m-d') }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Tracking No:</strong>
                                            <span>{{ $quotation->tracking_no ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Created By:</strong>
                                            <span>{{ $quotation->createdBy->name ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Grand Total:</strong>
                                            <span>TK {{ number_format($quotation->grand_total ?? 0, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #17a2b8, #0d6efd);">
                                        <h5 class="mb-0 fw-bold">Quotation Items</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Code</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($quotation->quotationItems as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $item->product_name ?? '-' }}</td>
                                                        <td>{{ $item->product_code ?? '-' }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>TK {{ number_format($item->price ?? 0, 2) }}</td>
                                                        <td>TK {{ number_format($item->total ?? 0, 2) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">No items found</td>
                                                    </tr>
                                                @endforelse
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
@endsection