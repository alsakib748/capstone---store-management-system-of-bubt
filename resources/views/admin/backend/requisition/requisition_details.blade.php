@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0"> Requisition Details</h3>
                    <div class="text-end my-2 mt-md-0"><a class="btn btn-outline-primary"
                            href="{{ route('all.requisition') }}">Back</a></div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            {{-- User info --}}
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; transition: 0.2s">
                                    <div class="card-header text-white text-center"
                                        style="background: linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0 0;">
                                        <h5 class="mb-0 fw-bold">User Information</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Name:</strong>
                                            <span>{{ $requisition->user->name ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Email:</strong>
                                            <span>{{ $requisition->user->email ?? '-' }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- End User info --}}


                            {{-- Requisition info --}}
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm border-0 h-100" style="border-radius: 10px; transition: 0.2s">
                                    <div class="card-header text-white text-center"
                                        style="background: linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0 0;">
                                        <h5 class="mb-0 fw-bold">Requisition Information</h5>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Date:</strong>
                                            <span>{{ $requisition->date }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Semester:</strong>
                                            <span>{{ $requisition->semester ? (($requisition->semester->code ? $requisition->semester->code . ' : ' : '') . $requisition->semester->name) : '-' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <strong class="me-2 text-muted">Notes:</strong>
                                            <span>{{ $requisition->notes ?? '-' }}</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- End Requisition info --}}

                            {{-- Order Summary  --}}
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card shadow-sm border-0 h-100"
                                            style="border-radius: 10px; transition: 0.2s">
                                            <div class="card-header text-white text-center"
                                                style="background: linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0 0;">
                                                <h5 class="mb-0 fw-bold">Requisition Items</h5>
                                            </div>


                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Product Name</th>
                                                            <th>Product Code</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($requisition->requisitionItems as $key => $item)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $item->product->name }}</td>
                                                                <td>{{ $item->product->code }}</td>
                                                                <td>{{ $item->qty }}</td>
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