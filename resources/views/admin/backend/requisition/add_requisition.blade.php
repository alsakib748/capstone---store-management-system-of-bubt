@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Create Requisition</h3>
                    <div class="text-end my-2 mt-md-0"><a class="btn btn-outline-primary"
                            href="{{ route('all.requisition') }}">Back</a></div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('store.requisition') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Date: <span class="text-danger">*</span></label>
                                                <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"
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
                                                            <option value="{{ $item->id }}">{{ $item->code }} :
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('semester_id')
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

                                            {{-- <div class="col-md-4 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">User : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="user_id" id="user_id"
                                                        class="form-control form-select select2">
                                                        <option value="">Select User</option>
                                                    </select>
                                                    @error('user_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div> --}}

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label">Order items: <span
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
                                                            <th>Qty</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productBody">

                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Notes: </label>
                                            <textarea class="form-control" name="notes" rows="3" placeholder="Enter Notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="d-flex mt-5 justify-content-end">
                                    <button class="btn btn-primary me-3" type="submit">Save</button>
                                    <a class="btn btn-secondary" href="{{ route('all.requisition') }}">Cancel</a>
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
                const searchUrl = "{{ route('requisition.product.search') }}";
                const searchInput = document.getElementById('product_search');
                const productList = document.getElementById('product_list');
                const productBody = document.getElementById('productBody');
                const requisitionUserSelect = document.getElementById('user_id');

                function renderSearchResults(products) {
                    productList.innerHTML = '';
                    products.forEach((product) => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = product.code + ' - ' + product.name;
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
                        <td>
                            <input type="number" class="form-control text-center" name="products[${product.id}][quantity]" value="1" min="1" style="max-width: 90px;">
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

                    const selectedUserId = requisitionUserSelect ? requisitionUserSelect.value : '';
                    const searchParams = new URLSearchParams({
                        query: query
                    });
                    if (selectedUserId) {
                        searchParams.append('user_id', selectedUserId);
                    }

                    fetch(searchUrl + '?' + searchParams.toString(), {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then((response) => response.json())
                        .then((products) => renderSearchResults(products));
                });

                if (requisitionUserSelect) {
                    requisitionUserSelect.addEventListener('change', function() {
                        productList.innerHTML = '';
                        searchInput.value = '';
                    });
                }

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
