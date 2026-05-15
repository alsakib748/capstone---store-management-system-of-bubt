@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Requisition</h4>
                </div>

                @can('Requisition::add')
                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('add.requisition') }}" class="btn btn-secondary">Add Requisition</a>
                    </ol>
                </div>
                @endcan
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
                                            <th>Department</th>
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
                                                <td>{{ $item?->user?->department->name ?? '-' }}</td>
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

                                                        @can('Requisition::edit')
                                                            @if ($item->status !== 'issued')
                                                                <a title="Place Issue"
                                                                    href="{{ route('edit.requisition', $item->id) }}"
                                                                    class="btn btn-success btn-sm"> <span
                                                                        class="mdi mdi-check-circle mdi-18px"></span> </a>
                                                            @endif
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



        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection
