@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Requisition</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('add.requisition') }}" class="btn btn-secondary">Add Requisition</a>
                    </ol>
                </div>
            </div>

            <!-- Datatables  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">

                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-striped align-middle w-100 nowrap">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Semester</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $item)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}</td>
                                                <td>{{ $item?->user->name ?? '-' }}</td>
                                                <td>{{ $item?->user->email ?? '-' }}</td>
                                                <td>
                                                    {{ $item->semester ? ($item->semester->code ? $item->semester->code . ' : ' : '') . $item->semester->name : '-' }}
                                                </td>
                                                <td>
                                                    @if ($item->status === 'issued')
                                                        <span class="badge bg-success">Issued</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <a title="Details"
                                                            href="{{ route('details.requisition', $item->id) }}"
                                                            class="btn btn-info btn-sm"> <span
                                                                class="mdi mdi-eye-circle mdi-18px"></span> </a>

                                                        <a title="Invoice"
                                                            href="{{ route('invoice.requisition', $item->id) }}"
                                                            class="btn btn-warning btn-sm" target="_blank"> <span
                                                                class="mdi mdi-file-pdf-box mdi-18px"></span> </a>

                                                        @if ($item->status !== 'issued')
                                                            <button title="Issue" type="button"
                                                                class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                                data-bs-target="#issueModal{{ $item->id }}">
                                                                <span class="mdi mdi-check-circle mdi-18px"></span>
                                                            </button>

                                                            <!-- Issue Modal -->
                                                            <div class="modal fade" id="issueModal{{ $item->id }}"
                                                                tabindex="-1" aria-labelledby="issueModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="issueModalLabel">Issue Requisition
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <form
                                                                            action="{{ route('issue.requisition', $item->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <div class="mb-3">
                                                                                    <label for="issue_date"
                                                                                        class="form-label">Issue Date</label>
                                                                                    <input type="date" class="form-control"
                                                                                        id="issue_date" name="issue_date"
                                                                                        value="{{ date('Y-m-d') }}"
                                                                                        required>
                                                                                </div>
                                                                                <p>Are you sure you want to issue this
                                                                                    requisition? This will create an Issue
                                                                                    record and deduct stock.</p>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Issue</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <a title="Edit"
                                                            href="{{ route('edit.requisition', $item->id) }}"
                                                            class="btn btn-success btn-sm"> <span
                                                                class="mdi mdi-book-edit mdi-18px"></span> </a>

                                                        <a title="Delete"
                                                            href="{{ route('delete.requisition', $item->id) }}"
                                                            class="btn btn-danger btn-sm" id="delete"><span
                                                                class="mdi mdi-delete-circle  mdi-18px"></span></a>
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



        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection