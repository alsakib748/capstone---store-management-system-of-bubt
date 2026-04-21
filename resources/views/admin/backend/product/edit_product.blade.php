@extends('admin.admin_master')
@section('admin')

    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-0">
                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h2 class="fs-22 fw-semibold m-0">Edit Product</h2>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <a href="{{ route('all.product') }}" class="btn btn-dark">Back</a>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('update.product') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $editData->id }}">

                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Product Name: <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" placeholder="Enter Name"
                                                    class="form-control" value="{{ $editData->name }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Variant: <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="code" class="form-control"
                                                    value="{{ $editData->code }}">

                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">SKU</label>
                                                <input type="text" class="form-control bg-light"
                                                    value="{{ $editData->sku ?? '' }}" readonly tabindex="-1"
                                                    aria-readonly="true">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Product Category : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="category_id" id="category_id"
                                                        class="form-control form-select select2">
                                                        <option value="">Select Category</option>
                                                        @foreach ($categories as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $editData->category_id ? 'selected' : '' }}>
                                                                {{ $item->category_name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Subcategory : </label>
                                                    <select name="subcategory_id" id="subcategory_id"
                                                        class="form-control form-select select2">
                                                        <option value="">Select Subcategory</option>
                                                        @foreach ($subcategories as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $editData->subcategory_id ? 'selected' : '' }}>
                                                                {{ $item->subcategory_name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Brand : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="brand_id" id="brand_id"
                                                        class="form-control form-select select2">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($brands as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $editData->brand_id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>

                                            {{-- <div class="col-md-6 mb-3">
                                                <label class="form-label">Product Price: </label>
                                                <input type="text" name="price" class="form-control"
                                                    value="{{ $editData->price }}">

                                            </div> --}}


                                            {{-- <div class="col-md-6 mb-3">
                                                <label class="form-label">Stock Alert: <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="stock_alert" class="form-control"
                                                    value="{{ $editData->stock_alert }}" min="0" required>

                                            </div> --}}

                                            @php
                                                $selectedRoleIds = $editData->allowedRoles->pluck('id')->all();
                                            @endphp
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="role_id">Product Roles Permission :
                                                        <span class="text-danger">*</span></label>
                                                    <select name="role_ids[]" id="role_id"
                                                        class="form-control form-select select2" multiple
                                                        data-placeholder="Select roles">
                                                        @foreach ($roles as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ in_array($item->id, $selectedRoleIds, true) ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_ids')
                                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="card">
                                                <label class="form-label">Multiple Image: <span
                                                        class="text-danger">*</span></label>
                                                <div class="mb-3">
                                                    <input name="image[]" accept=".png, .jpg, .jpeg" multiple=""
                                                        type="file" id="multiImg"
                                                        class="upload-input-file form-control">
                                                </div>

                                                <div class="row" id="preview_img">
                                                    @if (isset($editData) && $editData->images->count() > 0)
                                                        @foreach ($editData->images as $img)
                                                            <div class="col-md-3 mb-2">
                                                                <img src="{{ asset($img->image) }}" alt="Product image"
                                                                    class="img-thumbnail">

                                                                <div class="form-check mt-1">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="remove_image[]" value="{{ $img->id }}"
                                                                        id="remove_image_{{ $img->id }}">
                                                                    <label for="remove_image_{{ $img->id }}"
                                                                        class="form-check-label">Remove</label>
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-md-12 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="fixed_asset" value="1" id="fixed_asset" {{ $editData->fixed_asset == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="fixed_asset">
                                                        Fixed Asset
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label class="form-label">Notes: </label>
                                                <textarea class="form-control" name="note" rows="3" placeholder="Enter Notes">{{ $editData->note }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">

                                    <div>
                                        <div class="col-md-12 mb-3">
                                            <h4 class="text-center">Add Stock : </h4>
                                        </div>
                                        {{-- <div class="col-md-12 mb-3">
                                            <div class="form-group w-100">
                                                <label class="form-label" for="formBasic">Warehouse : <span
                                                        class="text-danger">*</span></label>
                                                <select name="warehouse_id" id="warehouse_id"
                                                    class="form-control form-select select2">
                                                    <option value="">Select Warehouse</option>
                                                    @foreach ($warehouses as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $editData->warehouse_id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div> --}}
                                        {{-- <div class="col-md-12 mb-3">
                                            <div class="form-group w-100">
                                                <label class="form-label" for="formBasic">Supplier : <span
                                                        class="text-danger">*</span></label>
                                                <select name="supplier_id" id="supplier_id"
                                                    class="form-control form-select select2">
                                                    <option value="">Select Supplier</option>
                                                    @foreach ($suppliers as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $editData->supplier_id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div> --}}

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Initial Quantity: <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="product_qty" class="form-control"
                                                value="{{ $editData->product_qty }}" min="1" required>

                                        </div>

                                        {{-- <div class="col-md-12">
                                            <div class="form-group w-100">
                                                <label class="form-label" for="formBasic">Status : <span
                                                        class="text-danger">*</span></label>
                                                <select name="status" id="status"
                                                    class="form-control form-select select2">
                                                    <option selected="">Select Status</option>

                                                    <option value="Received"
                                                        {{ isset($editData->status) && $editData->status == 'Received' ? 'selected' : '' }}>
                                                        Received</option>

                                                    <option value="Pending"
                                                        {{ isset($editData->status) && $editData->status == 'Pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                </select>
                                            </div>
                                        </div> --}}

                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="d-flex mt-5 justify-content-start">
                                        <button class="btn btn-primary me-3" type="submit">Save</button>
                                        <a class="btn btn-secondary" href="{{ route('all.product') }}">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- AJAX to load subcategories based on category selection -->
        <script>
            $(function() {
                var $category = $('#category_id');
                var $subcategory = $('#subcategory_id');
                var initialSubcategoryId = "{{ $editData->subcategory_id }}";
                var endpointBase = "{{ url('get/subcategory') }}";

                function resetSubcategory() {
                    $subcategory.empty().append('<option value="">Select Subcategory</option>');
                    $subcategory.prop('disabled', true).trigger('change');
                    if ($subcategory.data('select2')) $subcategory.trigger('change.select2');
                }

                function populateSubcategories(data, selectedId) {
                    $subcategory.empty().append('<option value="">Select Subcategory</option>');

                    if (!data || !data.length) {
                        $subcategory.prop('disabled', true).trigger('change');
                        if ($subcategory.data('select2')) $subcategory.trigger('change.select2');
                        return;
                    }

                    $.each(data, function(_, item) {
                        $subcategory.append(
                            $('<option/>', {
                                value: item.id,
                                text: item.subcategory_name,
                                selected: String(selectedId) === String(item.id)
                            })
                        );
                    });

                    $subcategory.prop('disabled', false).trigger('change');
                    if ($subcategory.data('select2')) $subcategory.trigger('change.select2');
                }

                function loadSubcategories(categoryId, selectedId) {
                    resetSubcategory();
                    if (!categoryId) return;

                    $.ajax({
                        url: endpointBase + '/' + encodeURIComponent(categoryId),
                        type: 'GET',
                        dataType: 'json',
                        cache: false,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        success: function(res) {
                            populateSubcategories(res, selectedId);
                        },
                        error: resetSubcategory
                    });
                }

                $(document).on('change', '#category_id', function() {
                    loadSubcategories($(this).val(), '');
                });

                if ($category.val()) {
                    loadSubcategories($category.val(), initialSubcategoryId);
                } else {
                    resetSubcategory();
                }
            });
        </script>
    @endpush

@endsection
