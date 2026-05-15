@extends('admin.admin_master')
@section('admin')

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">All Department</h4>
            </div>

            @can('Department::add')
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                     <a href="{{ route('add.department') }}" class="btn btn-secondary">Add Department</a>
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
    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
        <thead>
        <tr>
            <th>Sl</th>
            <th>Department Name</th>
            <th>Department Code</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
           @foreach ($department as $key=> $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->code }}</td>
                <td>
            @can('Department::edit')
                <a href="{{ route('edit.department',$item->id) }}" class="btn btn-success btn-sm">Edit</a>
            @endcan
            @can('Department::delete')
                <a href="{{ route('delete.department',$item->id) }}" class="btn btn-danger btn-sm" id="delete">Delete</a>
            @endcan
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

                </div>
            </div>
        </div>



    </div> <!-- container-fluid -->

</div> <!-- content -->



@endsection
