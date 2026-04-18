@extends('admin.admin_master')
@section('admin')

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Edit Subcategory</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <a href="{{ route('all.subcategory') }}" class="btn btn-dark">Back</a>
                </ol>
            </div>
        </div>

        <!-- Form Validation -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Subcategory</h5>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form action="{{ route('update.subcategory') }}" method="post" class="row g-3">
                            @csrf
                            <input type="hidden" name="id" value="{{ $subcategory->id }}">

                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Category</label>
                                <select name="category_id" class="form-control form-select select2" required>
                                    <option value="" selected>Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $subcategory->category_id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="validationDefault01" class="form-label">Subcategory Name</label>
                                <input type="text" class="form-control" name="subcategory_name"
                                    value="{{ $subcategory->subcategory_name }}" required>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->

</div> <!-- content -->




@endsection