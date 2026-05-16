@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Create Purchase</h3>
                    <div class="text-end my-2 mt-md-0"><a class="btn btn-outline-primary"
                            href="{{ route('all.purchase') }}">Back</a></div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('store.purchase') }}" method="post" enctype="multipart/form-data">
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

                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Product:</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-search"></i>
                                                        </span>
                                                        <input type="search" id="product_search" name="search"
                                                            class="form-control" placeholder="Search product by code or name">
                                                    </div>
                                                    <div id="product_list" class="list-group mt-2"></div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Semester : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="semester_id" id="semester_id"
                                                        class="form-control form-select select2">
                                                        <option value="">Select Semester</option>
                                                        @foreach ($semesters as $item)
                                                            <option value="{{ $item->id }}">{{ $item->code }} : {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('semester_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Department : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="department_id" id="department_id"
                                                        class="form-control form-select select2">
                                                        <option value="">Select Department</option>
                                                        @foreach ($departments as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}  -  ({{ $item->code }})</option>
                                                        @endforeach
                                                    </select>
                                                    @error('department_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 mb-3">
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
                                            </div>


                                            {{-- <div class="col-md-4 mb-3">
                <div class="form-group w-100">
                <label class="form-label" for="formBasic">Warehouse : <span class="text-danger">*</span></label>
                <select name="warehouse_id" id="warehouse_id" class="form-control form-select select2">
                      <option value="">Select Warehouse</option>
                      @foreach ($warehouses as $item)
                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                      @endforeach
                </select>
                <small id="warehouse_error" class="text-danger d-none">Please select the first warehouse.</small>
                </div>
          </div> --}}

                                            <div class="col-md-4 mb-3">
                                                <div class="form-group w-100">
                                                    <label class="form-label" for="formBasic">Supplier : <span
                                                            class="text-danger">*</span></label>
                                                    <select name="supplier_id" id="supplier_id"
                                                        class="form-control form-select select2">
                                                        <option value="">Select Supplier</option>
                                                        @foreach ($suppliers as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('supplier_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
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
                                                            <th>Net Unit Cost</th>
                                                            <th>Stock</th>
                                                            <th>Qty</th>
                                                            <th>Discount</th>
                                                            <th>Subtotal</th>
                                                            <th>Expiry Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="orderItemsTableBody">

                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 ms-auto">
                                                <div class="card">
                                                    <div class="card-body pt-7 pb-2">
                                                        <div class="table-responsive">
                                                            <table class="table border">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="py-3">Discount</td>
                                                                        <td class="py-3" id="displayDiscount">TK 0.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="py-3">Shipping</td>
                                                                        <td class="py-3" id="shippingDisplay">TK 0.00</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="py-3 text-primary">Grand Total</td>
                                                                        <td class="py-3 text-primary" id="grandTotal">TK
                                                                            0.00</td>
                                                                        <input type="hidden" name="grand_total">
                                                                    </tr>


                                                                    <tr class="d-none">
                                                                        <td class="py-3">Paid Amount</td>
                                                                        <td class="py-3" id="paidAmount">
                                                                            <input type="text" name="paid_amount"
                                                                                placeholder="Enter amount paid"
                                                                                class="form-control">
                                                                        </td>
                                                                    </tr>
                                                                    <!-- new add full paid functionality  -->
                                                                    <tr class="d-none">
                                                                        <td class="py-3">Full Paid</td>
                                                                        <td class="py-3" id="fullPaid">
                                                                            <input type="text" name="full_paid"
                                                                                id="fullPaidInput">
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="d-none">
                                                                        <td class="py-3">Due Amount</td>
                                                                        <td class="py-3" id="dueAmount">TK 0.00</td>
                                                                        <input type="hidden" name="due_amount">
                                                                    </tr>


                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Tracking No: </label>
                                                <input type="text" id="tracking_no" name="tracking_no"
                                                    class="form-control" placeholder="Tracking No">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Note No: </label>
                                                <input type="text" id="note_no" name="note_no"
                                                    class="form-control" placeholder="Note No">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Voucher / File Upload: </label>
                                                <input type="file" id="file_upload" name="file_upload"
                                                    class="form-control" placeholder="Voucher / File Upload">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Discount: </label>
                                                <input type="number" id="inputDiscount" name="discount"
                                                    class="form-control" value="0.00">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Shipping: </label>
                                                <input type="number" id="inputShipping" name="shipping"
                                                    class="form-control" value="0.00">
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Notes: </label>
                                            <textarea class="form-control" name="note" rows="3" placeholder="Enter Notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="d-flex mt-5 justify-content-end">
                                    <button class="btn btn-primary me-3" type="submit">Save</button>
                                    <a class="btn btn-secondary" href="{{ route('all.purchase') }}">Cancel</a>
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
        var productSearchUrl = "{{ route('purchase.product.search') }}"
        window.useWarehouseForProductSearch = false;

        $(function() {
            var $department = $('#department_id');
            var $user = $('#user_id');
            var initialUserId = "{{ old('user_id') }}";
            var endpointBase = "{{ url('get/users/by/department') }}";

            function resetUser() {
                $user.empty().append('<option value="">Select User</option>');
                $user.prop('disabled', true).trigger('change');
            }

            function populateUsers(data, selectedId) {
                $user.empty().append('<option value="">Select User</option>');

                if (!data || !data.length) {
                    $user.prop('disabled', true).trigger('change');
                    return;
                }

                $.each(data, function(_, item) {
                    $user.append(
                        $('<option/>', {
                            value: item.id,
                            text: item.name + ' (' + item.email + ')',
                            selected: String(selectedId) === String(item.id)
                        })
                    );
                });

                $user.prop('disabled', false).trigger('change');
            }

            function loadUsers(departmentId, selectedId) {
                resetUser();
                if (!departmentId) return;

                $.ajax({
                    url: endpointBase + '/' + encodeURIComponent(departmentId),
                    type: 'GET',
                    dataType: 'json',
                    cache: false,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(res) {
                        populateUsers(res, selectedId);
                    },
                    error: resetUser
                });
            }

            $(document).on('change', '#department_id', function() {
                loadUsers($(this).val(), '');
                generateTrackingNumber($(this).val());
            });

            if ($department.val()) {
                loadUsers($department.val(), initialUserId);
                generateTrackingNumber($department.val());
            } else {
                resetUser();
            }

            function generateTrackingNumber(departmentId) {
                if (!departmentId) {
                    $('#tracking_no').val('');
                    return;
                }

                var now = new Date();
                var year = String(now.getFullYear());
                var month = String(now.getMonth() + 1).padStart(2, '0');
                var date = String(now.getDate()).padStart(2, '0');
                var hours = String(now.getHours()).padStart(2, '0');

                var selectedOption = $('#department_id option:selected');
                var deptText = selectedOption.text();
                var deptCodeMatch = deptText.match(/\(([^)]+)\)/);
                var deptCode = deptCodeMatch ? deptCodeMatch[1].toUpperCase() : '';

                var trackingNo = deptCode + '-' + year + '-' + month + '-' + date + '-' + hours;
                $('#tracking_no').val(trackingNo);
            }
        });
    </script>
    @endpush
@endsection
