@extends('admin.admin_master')
@section('admin')

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit User</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">

                    <li class="breadcrumb-item active">Edit User</li>
                </ol>
            </div>
        </div>

        <!-- Form Validation -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit User</h5>
                    </div><!-- end card header -->

<div class="card-body">
    <form action="{{ route('update.admin',$admin->id) }}" method="post" class="row g-3" enctype="multipart/form-data">
        @csrf

        @php
            $editRoleId = old('roles', $admin->roles->first()?->id);
        @endphp

        <div class="col-md-6">
            <label for="user_name" class="form-label">User Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="user_name" value="{{ old('name', $admin->name) }}">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

          <div class="col-md-6">
            <label for="user_email" class="form-label">User Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="user_email" value="{{ old('email', $admin->email) }}">
            @error('email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

          <div class="col-md-6">
            <label for="user_department_id" class="form-label">Department </label>
            <select name="department_id" class="form-select select2 @error('department_id') is-invalid @enderror" id="user_department_id" data-placeholder="Select Department">
                <option value="" @selected(old('department_id', $admin->department_id) === '' || old('department_id', $admin->department_id) === null)>Select Department</option>
                 @foreach ($departments as $department)
                <option value="{{ $department->id }}" @selected((string) old('department_id', $admin->department_id) === (string) $department->id)>{{ $department->name }}</option>
                  @endforeach
            </select>
            @error('department_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


          <div class="col-md-6">
            <label for="user_role_id" class="form-label">Role </label>
            <select name="roles" class="form-select select2 @error('roles') is-invalid @enderror" id="user_role_id" data-placeholder="Select Role">
                <option value="" @selected($editRoleId === null || $editRoleId === '')>Select Role</option>
                 @foreach ($roles as $role)
                <option value="{{ $role->id }}" @selected((string) $editRoleId === (string) $role->id)>{{ $role->name }}</option>
                  @endforeach
            </select>
            @error('roles')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>



        <div class="col-12">
            <button class="btn btn-primary" type="submit">Save Change</button>
        </div>
    </form>
</div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->


        </div>



    </div> <!-- container-fluid -->

</div>


@endsection
