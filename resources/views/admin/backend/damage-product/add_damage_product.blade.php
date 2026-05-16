@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Create Damage Product</h3>
                    <div class="text-end my-2 mt-md-0"><a class="btn btn-outline-primary"
                            href="{{ route('all.damage.product') }}">Back</a></div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('store.damage.product') }}" method="post" enctype="multipart/form-data">
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
                                                            class="form-control"
                                                            placeholder="Search product by code or name">
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
                                                            <option value="{{ $item->id }}">{{ $item->code }} :
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('semester_id')
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
                                                            <th>Stock</th>
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

                                        <br/>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Tracking No: </label>
                                                <input type="text" id="tracking_no" name="tracking_no"
                                                    class="form-control" placeholder="Tracking No">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Note No: </label>
                                                <input type="text" id="note_no" name="note_no" class="form-control"
                                                    placeholder="Note No">
                                            </div>
                                            {{-- <div class="col-md-4 mb-3">
                                                <label class="form-label">Voucher / File Upload: </label>
                                                <input type="file" id="file_upload" name="file_upload"
                                                    class="form-control" placeholder="Voucher / File Upload">
                                            </div> --}}
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
                                    <a class="btn btn-secondary" href="{{ route('all.damage.product') }}">Cancel</a>
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
                const addPageSearchUrl = "{{ route('damage.product.product.search') }}";
                const addPageSearchInput = document.getElementById('product_search');
                const addPageProductList = document.getElementById('product_list');
                const addPageProductBody = document.getElementById('productBody');

                function addPageRenderSearchResults(products) {
                    addPageProductList.innerHTML = '';

                    products.forEach((product) => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = product.code + ' - ' + product.name + ' (Stock: ' + product.product_qty + ')';
                        item.addEventListener('click', function(e) {
                            e.preventDefault();
                            addPageAddProductRow(product);
                            addPageProductList.innerHTML = '';
                            addPageSearchInput.value = '';
                        });
                        addPageProductList.appendChild(item);
                    });
                }

                function addPageAddProductRow(product) {
                    const existingRow = addPageProductBody.querySelector('input[name="products[' + product.id + '][id]"]');
                    if (existingRow) {
                        alert('Product already added');
                        return;
                    }

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <input type="text" class="form-control" value="${product.code} - ${product.name}" readonly style="max-width: 300px">
                            <input type="hidden" name="products[${product.id}][id]" value="${product.id}">
                        </td>
                        <td>
                            <input type="number" class="form-control" value="${product.product_qty}" style="max-width: 80px;" readonly>
                        </td>
                        <td>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary decrement-qty" type="button">-</button>
                                <input type="number" class="form-control text-center qty-input" name="products[${product.id}][quantity]" value="1" min="1" style="max-width: 70px;">
                                <button class="btn btn-outline-secondary increment-qty" type="button">+</button>
                            </div>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-item"><span class="mdi mdi-delete-circle mdi-18px"></span></button></td>
                    `;
                    addPageProductBody.appendChild(row);
                }

                addPageSearchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    if (query.length < 2) {
                        addPageProductList.innerHTML = '';
                        return;
                    }

                    fetch(addPageSearchUrl + '?query=' + encodeURIComponent(query), {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then((response) => response.json())
                        .then((products) => addPageRenderSearchResults(products));
                });

                addPageProductBody.addEventListener('click', function(e) {
                    const removeBtn = e.target.closest('.remove-item');
                    if (removeBtn) {
                        removeBtn.closest('tr').remove();
                        return;
                    }

                    const incBtn = e.target.closest('.increment-qty');
                    if (incBtn) {
                        const input = incBtn.closest('.input-group').querySelector('.qty-input');
                        input.value = parseInt(input.value || '0', 10) + 1;
                    }

                    const decBtn = e.target.closest('.decrement-qty');
                    if (decBtn) {
                        const input = decBtn.closest('.input-group').querySelector('.qty-input');
                        const currentQty = parseInt(input.value || '1', 10);
                        input.value = currentQty > 1 ? currentQty - 1 : 1;
                    }
                });
            });
        </script>
    @endpush
@endsection
