@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Issue Return Details</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('all.issue.return') }}" class="btn btn-secondary">Back</a>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Return Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td class="text-muted fw-medium">Return Date:</td>
                                        <td>{{ \Carbon\Carbon::parse($issueReturn->return_date)->format('Y-m-d') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">User (Returner):</td>
                                        <td>{{ $issueReturn->user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Email:</td>
                                        <td>{{ $issueReturn->user->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Original Issue:</td>
                                        <td>{{ $issueReturn->issue->tracking_no ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Issue Date:</td>
                                        <td>{{ $issueReturn->issue ? \Carbon\Carbon::parse($issueReturn->issue->date)->format('Y-m-d') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Created By:</td>
                                        <td>{{ $issueReturn->createdBy->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Notes:</td>
                                        <td>{{ $issueReturn->notes ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    {{-- Return Items --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Return Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Code</th>
                                            <th>Qty</th>
                                            <th>Condition</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($issueReturn->issueReturnItems as $item)
                                            <tr>
                                                <td>{{ $item->product->name ?? '-' }}</td>
                                                <td>{{ $item->product->code ?? '-' }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>
                                                    @if($item->condition == 'good')
                                                        <span class="badge bg-success">Good</span>
                                                    @else
                                                        <span class="badge bg-danger">Damaged</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No return items</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <a href="{{ route('invoice.issue.return', $issueReturn->id) }}" class="btn btn-warning" target="_blank">
                                    <i class="mdi mdi-file-pdf-box me-1"></i> Invoice
                                </a>
                                <a href="{{ route('edit.issue.return', $issueReturn->id) }}" class="btn btn-success">
                                    <i class="mdi mdi-book-edit me-1"></i> Edit
                                </a>
                                <a href="{{ route('delete.issue.return', $issueReturn->id) }}" class="btn btn-danger" id="delete">
                                    <i class="mdi mdi-delete-circle me-1"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection