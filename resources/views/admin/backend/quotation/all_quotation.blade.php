@extends('admin.admin_master')
@section('admin')
    <div class="content">
        <div class="container-xxl">
            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Quotation</h4>
                </div>
                <div class="text-end">
                    <a href="{{ route('add.quotation') }}" class="btn btn-primary">Add Quotation</a>
                </div>
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
                                            <th>Quotation No</th>
                                            <th>Date</th>
                                            <th>Supplier</th>
                                            <th>Grand Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($allData as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->quotation_no ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->quotation_date)->format('Y-m-d') }}</td>
                                                <td>{{ $item->supplier->name ?? '-' }}</td>
                                                <td>TK {{ number_format($item->grand_total ?? 0, 2) }}</td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <a title="Details" href="{{ route('details.quotation', $item->id) }}" class="btn btn-info btn-sm">
                                                            <span class="mdi mdi-eye-circle mdi-18px"></span>
                                                        </a>
                                                        <a title="PDF Invoice" href="{{ route('invoice.quotation', $item->id) }}" class="btn btn-warning btn-sm" target="_blank">
                                                            <span class="mdi mdi-file-pdf-box mdi-18px"></span>
                                                        </a>
                                                        <a title="Edit" href="{{ route('edit.quotation', $item->id) }}" class="btn btn-success btn-sm">
                                                            <span class="mdi mdi-book-edit mdi-18px"></span>
                                                        </a>
                                                        <a title="Delete" href="{{ route('delete.quotation', $item->id) }}" class="btn btn-danger btn-sm" id="delete">
                                                            <span class="mdi mdi-delete-circle mdi-18px"></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No quotations found</td>
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
@endsection