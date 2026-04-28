@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Issues</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('add.issue') }}" class="btn btn-secondary">Add Issue</a>
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
                                            <th>Semester</th>
                                            <th>Department</th>
                                            <th>Issued By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $item)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}</td>
                                                <td>{{ $item?->user->name ?? '-' }}</td>
                                                <td>
                                                    {{ $item->semester ? ($item->semester->code ? $item->semester->code . ' : ' : '') . $item->semester->name : '-' }}
                                                </td>
                                                <td>{{ $item?->department?->name ?? '-' }}</td>
                                                <td>{{ $item?->issuedByUser?->name ?? '-' }}</td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <a title="Details" href="{{ route('details.issue', $item->id) }}"
                                                            class="btn btn-info btn-sm"> <span
                                                                class="mdi mdi-eye-circle mdi-18px"></span> </a>

                                                        <a title="Invoice" href="{{ route('invoice.issue', $item->id) }}"
                                                            class="btn btn-warning btn-sm" target="_blank"> <span
                                                                class="mdi mdi-file-pdf-box mdi-18px"></span> </a>

                                                        <a title="Edit" href="{{ route('edit.issue', $item->id) }}"
                                                            class="btn btn-success btn-sm"> <span
                                                                class="mdi mdi-book-edit mdi-18px"></span> </a>

                                                        <a title="Delete" href="{{ route('delete.issue', $item->id) }}"
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
