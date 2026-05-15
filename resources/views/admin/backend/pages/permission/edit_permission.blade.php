@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Edit Permission</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">

                        <li class="breadcrumb-item active">Edit Permission</li>
                    </ol>
                </div>
            </div>

            <!-- Form Validation -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Edit Permission</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <form action="{{ route('update.permission') }}" method="post" class="row g-3"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $permissions->id }}">

                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Permission Name</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $permissions->display_name ?? $permissions->name }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="validationDefault01" class="form-label">Permission Group</label>
                                    <select name="group_name" class="form-select select2" id="example-select">
                                        <option value="" selected>Select Group</option>
                                        <option value="Brand" {{ $permissions->group_name == 'Brand' ? 'selected' : '' }}>
                                            Brand</option>
                                        <option value="Supplier"
                                            {{ $permissions->group_name == 'Supplier' ? 'selected' : '' }}>Supplier</option>
                                        <option value="Category"
                                            {{ $permissions->group_name == 'Category' ? 'selected' : '' }}>Category</option>
                                        <option value="SubCategory"
                                            {{ $permissions->group_name == 'SubCategory' ? 'selected' : '' }}>SubCategory
                                        </option>
                                        <option value="Product"
                                            {{ $permissions->group_name == 'Product' ? 'selected' : '' }}>Product</option>
                                        <option value="Damage Product"
                                            {{ $permissions->group_name == 'Damage Product' ? 'selected' : '' }}>Damage
                                            Product</option>
                                        <option value="Purchase"
                                            {{ $permissions->group_name == 'Purchase' ? 'selected' : '' }}>Purchase</option>
                                        <option value="Purchase Return"
                                            {{ $permissions->group_name == 'Purchase Return' ? 'selected' : '' }}>Purchase
                                            Return</option>
                                        <option value="Requisition"
                                            {{ $permissions->group_name == 'Requisition' ? 'selected' : '' }}>Requisition
                                        </option>
                                        <option value="Issue" {{ $permissions->group_name == 'Issue' ? 'selected' : '' }}>
                                            Issue</option>
                                        <option value="Issue Return"
                                            {{ $permissions->group_name == 'Issue Return' ? 'selected' : '' }}>Issue Return
                                        </option>
                                        <option value="Quotation"
                                            {{ $permissions->group_name == 'Quotation' ? 'selected' : '' }}>Quotation
                                        </option>
                                        <option value="Report"
                                            {{ $permissions->group_name == 'Report' ? 'selected' : '' }}>Report</option>
                                        <option value="Chat" {{ $permissions->group_name == 'Chat' ? 'selected' : '' }}>
                                            Chat</option>
                                        <option value="Semester"
                                            {{ $permissions->group_name == 'Semester' ? 'selected' : '' }}>Semester
                                        </option>
                                        <option value="Department"
                                            {{ $permissions->group_name == 'Department' ? 'selected' : '' }}>Department
                                        </option>
                                        <option value="Role Permission"
                                            {{ $permissions->group_name == 'Role Permission' ? 'selected' : '' }}>Role
                                            Permission</option>
                                        <option value="Manage User"
                                            {{ $permissions->group_name == 'Manage User' ? 'selected' : '' }}>Manage User
                                        </option>
                                        <option value="Stock" {{ $permissions->group_name == 'Stock' ? 'selected' : '' }}>
                                            Stock</option>
                                    </select>
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
