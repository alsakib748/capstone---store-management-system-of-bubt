@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Create Issue Return</h3>
                    <div class="text-end my-2 mt-md-0"><a class="btn btn-outline-primary"
                            href="{{ route('all.issue') }}">Back</a></div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('store.issue.return') }}" method="post" enctype="multipart/form-data">
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
                                                    <label class="form-label" for="formBasic">Department : </label>
                                                    <select name="department_id" id="department_id"
                                                        class="form-control form-select select2"
                                                        data-placeholder="Select Department (for filtering user)">
                                                        <option value=""></option>
                                                        @foreach ($departments as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
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
                                                    </select>
                                                    @error('user_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label">Issue Reference : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="issue_id" id="issue_id"
                                                        class="form-control form-select select2"
                                                        data-placeholder="Select Issue">
                                                        <option value="">Select Issue</option>
                                                        @foreach ($issues as $issue)
                                                            <option value="{{ $issue->id }}">
                                                                {{ $issue->tracking_no }} --
                                                                {{ $issue->user->name ?? '-' }} --
                                                                {{ $issue->semester->name ?? '-' }} --
                                                                {{ \Carbon\Carbon::parse($issue->date)->format('Y-m-d') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('issue_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Products (from selected issue):</label>
                                                    <div id="issueProductsInfo" class="alert alert-info d-none">
                                                        Select an issue to see available products for return
                                                    </div>
                                                    <div id="product_list" class="list-group mt-2"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label">Return Items: <span
                                                        class="text-danger">*</span></label>
                                                <table class="table table-striped table-bordered dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>Product</th>
                                                            <th>Brand</th>
                                                            <th>Category</th>
                                                            <th>Available Qty</th>
                                                            <th>Return Qty</th>
                                                            <th>Condition</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productBody">

                                                    </tbody>
                                                </table>
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
                                    <a class="btn btn-secondary" href="{{ route('all.issue.return') }}">Cancel</a>
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
                const issueSelect = document.getElementById('issue_id');
                const productBody = document.getElementById('productBody');

                // Filter users by department using jQuery for select2 compatibility
                $('#department_id').on('change', function() {
                    const departmentId = $(this).val();
                    const userUrl = "{{ route('get.users.by.department', ':department_id') }}".replace(
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

                // Load products when issue is selected
                $('#issue_id').on('change', function() {
                    const issueId = $(this).val();
                    const productBody = document.getElementById('productBody');
                    productBody.innerHTML = '';

                    if (issueId) {
                        const url = "{{ route('get.issue.products', ':issue_id') }}".replace(':issue_id',
                            issueId);
                        fetch(url, {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.products && data.products.length > 0) {
                                    data.products.forEach((product) => {
                                        addProductToTable(product);
                                    });
                                } else {
                                    alert('No products available for return from this issue');
                                }
                            })
                            .catch((error) => {
                                console.error('Error loading products:', error);
                                alert('Error loading products');
                            });
                    }
                });

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
                        <td><input type="text" class="form-control text-center" value="${product.remaining_qty}" readonly style="max-width: 80px;"></td>
                        <td>
                            <input type="number" class="form-control text-center" name="products[${product.id}][quantity]" value="1" min="1" max="${product.remaining_qty}" style="max-width: 90px;">
                        </td>
                        <td>
                            <select name="products[${product.id}][condition]" class="form-select form-select-sm">
                                <option value="good">Good</option>
                                <option value="damaged">Damaged</option>
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-item"><span class="mdi mdi-delete-circle mdi-18px"></span></button></td>
                    `;
                    productBody.appendChild(row);
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
