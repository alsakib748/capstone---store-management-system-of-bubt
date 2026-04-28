@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Issue Details</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('all.issue') }}" class="btn btn-secondary">Back</a>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Issue Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td class="text-muted fw-medium">Date:</td>
                                        <td>{{ \Carbon\Carbon::parse($issue->date)->format('Y-m-d') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">User (Recipient):</td>
                                        <td>{{ $issue->user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Email:</td>
                                        <td>{{ $issue->user->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Semester:</td>
                                        <td>
                                            {{ $issue->semester ? ($issue->semester->code ? $issue->semester->code . ' : ' : '') . $issue->semester->name : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Department:</td>
                                        <td>{{ $issue->department->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Issued By:</td>
                                        <td>{{ $issue->issuedByUser->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-medium">Notes:</td>
                                        <td>{{ $issue->notes ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Issue Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Code</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($issue->issueItems as $item)
                                            <tr>
                                                <td>{{ $item->product->name ?? '-' }}</td>
                                                <td>{{ $item->product->code ?? '-' }}</td>
                                                <td>{{ $item->qty }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="d-flex gap-2">
                                <a href="{{ route('invoice.issue', $issue->id) }}" class="btn btn-warning" target="_blank">
                                    <i class="mdi mdi-file-pdf-box me-1"></i> Invoice
                                </a>
                                <a href="{{ route('edit.issue', $issue->id) }}" class="btn btn-success">
                                    <i class="mdi mdi-book-edit me-1"></i> Edit
                                </a>
                                <a href="{{ route('delete.issue', $issue->id) }}" class="btn btn-danger" id="delete">
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
