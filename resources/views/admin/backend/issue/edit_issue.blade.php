@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Edit Issue</h3>
                    <div class="text-end my-2 mt-md-0"><a class="btn btn-outline-primary"
                            href="{{ route('all.issue') }}">Back</a></div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('update.issue', $editData->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Date: <span class="text-danger">*</span></label>
                                                <input type="date" name="date" value="{{ $editData->date }}"
                                                    class="form-control">
                                                @error('date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Semester : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="semester_id" id="semester_id"
                                                        class="form-control form-select select2">
                                                        <option value="">Select Semester</option>
                                                        @foreach ($semesters as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $editData->semester_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->code }} : {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('semester_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Department : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="department_id" id="department_id"
                                                        class="form-control form-select select2"
                                                        data-placeholder="Select Department">
                                                        <option value=""></option>
                                                        @foreach ($departments as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $editData->department_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">User (Recipient) : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="user_id" id="user_id"
                                                        class="form-control form-select select2">
                                                        <option value="">Select User</option>
                                                        @foreach ($users->where('department_id', $editData->department_id) as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $editData->user_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }} - {{ $item->email }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Product:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-search"></i>
                                                        </span>
                                                        <input type="search" id="product_search" name="search"
                                                            class="form-control"
                                                            placeholder="Search product by code or name">
                                                    </div>
                                                    <div id="product_list" class="list-group mt-2"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label">Issue items: <span
                                                        class="text-danger">*</span></label>
                                                <div class="table-responsive">
                                                <table class="table table-striped table-bordered dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>Product</th>
                                                            <th>Brand</th>
                                                            <th>Category</th>
                                                            <th>Subcategory</th>
                                                            <th>Stock</th>
                                                            <th>Qty</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productBody">
                                                        @foreach ($editData->issueItems as $item)
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $item->product->code }} - {{ $item->product->name }}"
                                                                        readonly>
                                                                    <input type="hidden"
                                                                        name="products[{{ $item->product_id }}][id]"
                                                                        value="{{ $item->product_id }}">
                                                                </td>
                                                                <td><input type="text" class="form-control"
                                                                        value="{{ $item->product->brand->name ?? '-' }}"
                                                                        readonly></td>
                                                                <td><input type="text" class="form-control"
                                                                        value="{{ $item->product->category->category_name ?? '-' }}"
                                                                        readonly></td>
                                                                <td><input type="text" class="form-control"
                                                                        value="{{ $item->product->subcategory->subcategory_name ?? '-' }}"
                                                                        readonly></td>
                                                                <td><input type="text" class="form-control text-center"
                                                                        value="{{ $item->product->product_qty + $item->qty }}"
                                                                        readonly style="max-width: 80px;"></td>
                                                                <td>
                                                                    <input type="number" class="form-control text-center"
                                                                        name="products[{{ $item->product_id }}][quantity]"
                                                                        value="{{ $item->qty }}" min="1"
                                                                        style="max-width: 90px;">
                                                                </td>
                                                                <td><button type="button"
                                                                        class="btn btn-danger btn-sm remove-item"><span
                                                                            class="mdi mdi-delete-circle mdi-18px"></span></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Notes: </label>
                                            <textarea class="form-control" name="notes" rows="3" placeholder="Enter Notes">{{ $editData->notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="d-flex mt-5 justify-content-end">
                                    <button class="btn btn-primary me-3" type="submit">Update</button>
                                    <a class="btn btn-secondary" href="{{ route('all.issue') }}">Cancel</a>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const departmentSelect = document.getElementById('department_id');
                const userSelect = document.getElementById('user_id');

                // Filter users by department using jQuery for select2 compatibility
                $('#department_id').on('change', function() {
                    const departmentId = $(this).val();
                    const userUrl = "{{ route('issue.get.users.by.department', ':department_id') }}".replace(
                        ':department_id', departmentId);

                    $('#user_id').empty().append('<option value="">Select User</option>');

                    if (departmentId) {
                        $.ajax({
                            url: userUrl,
                            type: 'GET',
                            dataType: 'json',
                            success: function(users) {
                                $.each(users, function(index, user) {
                                    $('#user_id').append('<option value="' + user.id +
                                        '">' + user.name + ' - ' + user.email +
                                        '</option>');
                                });
                            }
                        });
                    }
                });

                const searchUrl = "{{ route('issue.product.search') }}";
                const searchInput = document.getElementById('product_search');
                const productList = document.getElementById('product_list');
                const productBody = document.getElementById('productBody');

                function renderSearchResults(products) {
                    productList.innerHTML = '';
                    products.forEach((product) => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = product.code + ' - ' + product.name + ' (Stock: ' + product.stock +
                            ')';
                        item.addEventListener('click', function(e) {
                            e.preventDefault();
                            addProductToTable(product);
                            productList.innerHTML = '';
                            searchInput.value = '';
                        });
                        productList.appendChild(item);
                    });
                }

                function addProductToTable(product) {
                    const existingRow = productBody.querySelector('input[name="products[' + product.id + '][id]"]');
                    if (existingRow) {
                        alert('Product already added');
                        return;
                    }

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <input type="text" class="form-control" value="${product.code} - ${product.name}" readonly>
                            <input type="hidden" name="products[${product.id}][id]" value="${product.id}">
                        </td>
                        <td><input type="text" class="form-control" value="${product.brand}" readonly></td>
                        <td><input type="text" class="form-control" value="${product.category}" readonly></td>
                        <td><input type="text" class="form-control" value="${product.subcategory}" readonly></td>
                        <td><input type="text" class="form-control text-center" value="${product.stock}" readonly style="max-width: 80px;"></td>
                        <td>
                            <input type="number" class="form-control text-center" name="products[${product.id}][quantity]" value="1" min="1" max="${product.stock}" style="max-width: 90px;">
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-item"><span class="mdi mdi-delete-circle mdi-18px"></span></button></td>
                    `;
                    productBody.appendChild(row);
                }

                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    if (query.length < 2) {
                        productList.innerHTML = '';
                        return;
                    }

                    fetch(searchUrl + '?query=' + encodeURIComponent(query), {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then((response) => response.json())
                        .then((products) => renderSearchResults(products));
                });

                productBody.addEventListener('click', function(e) {
                    const removeBtn = e.target.closest('.remove-item');
                    if (removeBtn) {
                        removeBtn.closest('tr').remove();
                    }
                });
            });
        </script>
    @endpush
@endsection
