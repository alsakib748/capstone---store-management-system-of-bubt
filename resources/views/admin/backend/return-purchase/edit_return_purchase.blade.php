@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Edit Return Purchase</h3>
                    <div class="text-end my-2 mt-md-0"><a class="btn btn-outline-primary"
                            href="{{ route('all.purchase') }}">Back</a></div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('update.return.purchase', $editData->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Date: <span class="text-danger">*</span></label>
                                                <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"
                                                    class="form-control" value="{{ $editData->date }}">
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

                                            {{-- <input type="hidden" name="warehouse_id" value="{{ $editData->warehouse_id }}"> --}}

                                            {{-- <div class="col-md-4 mb-3">
                <div class="form-group w-100">
                <label class="form-label" for="formBasic">Warehouse : <span class="text-danger">*</span></label>
                <select name="warehouse_id" id="warehouse_id" class="form-control form-select select2" disabled>
    <option value="">Select Warehouse</option>
    @foreach ($warehouses as $item)
    <option value="{{ $item->id }}" {{ $editData->warehouse_id == $item->id ? 'selected' : '' }} >{{ $item->name }}</option>
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
                                                            <option value="{{ $item->id }}"
                                                                {{ $editData->supplier_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
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
                                                            <option value="{{ $item->id }}"
                                                                {{ $editData->semester_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->code }} : {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label">Order items: <span
                                                        class="text-danger">*</span></label>
                                                <table class="table table-striped table-bordered dataTable"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>Product</th>
                                                            <th>Net Unit Cost</th>
                                                            <th>Stock</th>
                                                            <th>Qty</th>
                                                            <th>Subtotal</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productBody">
                                                        @foreach ($editData->purchaseItems as $item)
                                                            <tr data-id={{ $item->id }}>

                                                                <td class="d-flex align-items-center gap-2">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $item->product->code }} - {{ $item->product->name }}"
                                                                        readonly style="max-width: 300px">
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-sm edit-discount-btn"
                                                                        data-id="{{ $item->id }}"
                                                                        data-name="{{ $item->product->name }}"
                                                                        data-cost="{{ $item->net_unit_cost }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#discountModal">
                                                                        <span class="mdi mdi-book-edit "></span>
                                                                    </button>
                                                                </td>

                                                                <td>
                                                                    <input type="number"
                                                                        name="products[{{ $item->product->id }}][net_unit_cost]"
                                                                        class="form-control net-cost"
                                                                        value="{{ $item->net_unit_cost }}"
                                                                        style="max-width: 90px;" readonly>

                                                                </td>
                                                                <td>
                                                                    <input type="number"
                                                                        name="products[{{ $item->product->id }}][stock]"
                                                                        class="form-control"
                                                                        value="{{ $item->product->product_qty }}"
                                                                        style="max-width: 80px;" readonly>
                                                                </td>

                                                                <td>
                                                                    <div class="input-group">
                                                                        <button
                                                                            class="btn btn-outline-secondary decrement-qty"
                                                                            type="button">−</button>
                                                                        <input type="text"
                                                                            class="form-control text-center qty-input"
                                                                            name="products[{{ $item->product->id }}][quantity]"
                                                                            value="{{ $item->quantity }}" min="1"
                                                                            max="{{ $item->stock }}"
                                                                            data-cost="{{ $item->net_unit_cost }}"
                                                                            style="max-width: 50px;">
                                                                        <button
                                                                            class="btn btn-outline-secondary increment-qty"
                                                                            type="button">+</button>
                                                                    </div>
                                                                </td>

                                                                <td class="subtotal">
                                                                    {{ number_format($item->subtotal, 2) }}</td>
                                                                <input type="hidden"
                                                                    name="products[{{ $item->product->id }}][subtotal]"
                                                                    value="{{ $item->subtotal }}">

                                                                <td><button type="button"
                                                                        class="btn btn-danger btn-sm remove-item"
                                                                        data-id="{{ $item->id }}"><span
                                                                            class="mdi mdi-delete-circle mdi-18px"></span></button>
                                                                </td>

                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
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
                                                                        <td class="py-3">Shipping</td>
                                                                        <td class="py-3" id="shippingDisplay">TK
                                                                            {{ $editData->shipping }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="py-3 text-primary">Grand Total</td>
                                                                        <td class="py-3 text-primary" id="grandTotal">TK
                                                                            {{ $editData->grand_total }}</td>
                                                                        <input type="hidden" name="grand_total"
                                                                            value="{{ $editData->grand_total }}">
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
                                                    value="{{ $editData->tracking_no }}" class="form-control"
                                                    placeholder="Tracking No">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Note No: </label>
                                                <input type="text" id="note_no" name="note_no"
                                                    value="{{ $editData->note_no }}" class="form-control"
                                                    placeholder="Note No">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Voucher / File Upload: </label>
                                                <input type="file" id="file_upload" name="file_upload"
                                                    class="form-control" placeholder="Voucher / File Upload">
                                                @if ($editData->file_upload)
                                                    <small class="text-muted">Current: {{ $editData->file_upload }}</small>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Shipping: </label>
                                                <input type="number" id="inputShipping" name="shipping"
                                                    class="form-control" value="{{ $editData->shipping }}">
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Notes: </label>
                                            <textarea class="form-control" name="note" rows="3" placeholder="Enter Notes">{{ $editData->note }}</textarea>
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


    <script>
        var productSearchUrl = "{{ route('purchase.product.search') }}";
        window.useWarehouseForProductSearch = false;

        document.addEventListener("DOMContentLoaded", function() {
            const productBody = document.getElementById("productBody");

            function updateSubtotal(row) {
                let qty = parseFloat(row.querySelector(".qty-input")?.value) || 0;
                let netUnitCost = parseFloat(row.querySelector(".qty-input")?.dataset.cost) || 0;

                let subtotal = netUnitCost * qty;

                row.querySelector(".subtotal").innerText = subtotal.toFixed(2);

                const hiddenSubtotalInput = row.querySelector("input[name$='[subtotal]']");
                if (hiddenSubtotalInput) {
                    hiddenSubtotalInput.value = subtotal.toFixed(2);
                }

                updateGrandTotal();
            }

            function updateGrandTotal() {
                let grandTotal = 0;

                document.querySelectorAll(".subtotal").forEach(function(item) {
                    grandTotal += parseFloat(item.textContent) || 0;
                });

                let shipping = parseFloat(document.getElementById("inputShipping").value) || 0;

                grandTotal = grandTotal + shipping;

                if (grandTotal < 0) {
                    grandTotal = 0;
                }

                document.getElementById("grandTotal").textContent = `৳ ${grandTotal.toFixed(2)}`;
                document.querySelector("input[name='grand_total']").value = grandTotal.toFixed(2);
            }

            productBody.addEventListener("input", function(e) {
                if (e.target.classList.contains("qty-input")) {
                    updateSubtotal(e.target.closest("tr"));
                }
            });

            document.querySelectorAll(".increment-qty").forEach(button => {
                button.addEventListener("click", function() {
                    let input = this.closest(".input-group").querySelector(".qty-input");
                    let max = parseInt(input.getAttribute("max"));
                    let value = parseInt(input.value) || 0;
                    if (value < max) {
                        input.value = value + 1;
                        updateSubtotal(this.closest("tr"));
                    }
                });
            });

            document.querySelectorAll(".decrement-qty").forEach(button => {
                button.addEventListener("click", function() {
                    let input = this.closest(".input-group").querySelector(".qty-input");
                    let min = parseInt(input.getAttribute("min"));
                    let value = parseInt(input.value) || 0;
                    if (value > min) {
                        input.value = value - 1;
                        updateSubtotal(this.closest("tr"));
                    }
                });
            });

            document.getElementById("inputShipping").addEventListener("input", updateGrandTotal);

            productBody.addEventListener("click", function(e) {
                const removeBtn = e.target.closest(".remove-item");
                if (removeBtn) {
                    removeBtn.closest("tr").remove();
                    updateGrandTotal();
                }
            });

            updateGrandTotal();
        });
    </script>
@endsection
