@extends('admin.admin_master')
@section('admin')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Issue Return</h4>
                </div>
                @can('Issue Return::add')
                <div class="text-end">
                    <a href="{{ route('add.issue.return') }}" class="btn btn-primary">Add Issue Return</a>
                </div>
                @endcan
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-striped align-middle w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Date</th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Total Qty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $key => $item)
                                            @php
                                                $totalQty = $item->issueReturnItems->sum('qty') ?? 0;
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->return_date)->format('Y-m-d') }}</td>
                                                <td>{{ $item->user->name ?? '-' }}</td>
                                                <td>{{ $item->user->email ?? '-' }}</td>
                                                <td>{{ $totalQty }}</td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <a title="Details"
                                                            href="{{ route('details.issue.return', $item->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <span class="mdi mdi-eye-circle mdi-18px"></span>
                                                        </a>
                                                        <a title="Invoice"
                                                            href="{{ route('invoice.issue.return', $item->id) }}"
                                                            class="btn btn-warning btn-sm" target="_blank">
                                                            <span class="mdi mdi-file-pdf-box mdi-18px"></span>
                                                        </a>
                                                        @can('Issue Return::edit')
                                                            <a title="Edit" href="{{ route('edit.issue.return', $item->id) }}"
                                                                class="btn btn-success btn-sm">
                                                                <span class="mdi mdi-book-edit mdi-18px"></span>
                                                            </a>
                                                        @endcan
                                                        @can('Issue Return::delete')
                                                            <a title="Delete"
                                                                href="{{ route('delete.issue.return', $item->id) }}"
                                                                class="btn btn-danger btn-sm" id="delete">
                                                                <span class="mdi mdi-delete-circle mdi-18px"></span>
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </td>
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
@endsection
