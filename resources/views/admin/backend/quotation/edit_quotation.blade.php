@extends('admin.admin_master')
@section('admin')
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-column-fluid">
            <div class="container-fluid my-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <h3 class="mb-0">Edit Quotation</h3>
                    <div class="text-end my-2 mt-md-0">
                        <a class="btn btn-outline-primary" href="{{ route('all.quotation') }}">Back</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('update.quotation', $editData->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date: <span class="text-danger">*</span></label>
                                    <input type="date" name="date" value="{{ $editData->quotation_date }}"
                                        class="form-control">
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group w-100">
                                        <label class="form-label">Supplier: <span class="text-danger">*</span></label>
                                        <select name="supplier_id" id="supplier_id"
                                            class="form-control form-select select2">
                                            <option value="">Select Supplier</option>
                                            @forelse($suppliers as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $editData->supplier_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tracking No:</label>
                                    <input type="text" id="tracking_no" name="tracking_no"
                                        value="{{ $editData->tracking_no }}" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Product:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="search" id="product_search" name="search" class="form-control"
                                            placeholder="Search product by code or name">
                                    </div>
                                    <div id="product_list" class="list-group mt-2"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Quotation Items:</label>
                                    <div class="table-responsive">
                                    <table class="table table-striped table-bordered dataTable" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productBody">
                                            @forelse($editData->quotationItems as $item)
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            value="{{ $item->product_code }} - {{ $item->product_name }}"
                                                            readonly>
                                                        <input type="hidden" name="products[{{ $item->product_id }}][id]"
                                                            value="{{ $item->product_id }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control text-end"
                                                            name="products[{{ $item->product_id }}][price]"
                                                            value="{{ $item->price }}" min="0" step="0.01"
                                                            style="max-width: 120px;">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control text-center"
                                                            name="products[{{ $item->product_id }}][quantity]"
                                                            value="{{ $item->qty }}" min="1"
                                                            style="max-width: 80px;">
                                                    </td>
                                                    <td class="text-end">TK <span
                                                            class="item-total">{{ number_format($item->total, 2) }}</span>
                                                    </td>
                                                    <td><button type="button"
                                                            class="btn btn-danger btn-sm remove-item"><span
                                                                class="mdi mdi-delete-circle mdi-18px"></span></button></td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 ms-auto">
                                    <div class="card">
                                        <div class="card-body pt-7 pb-2">
                                            <table class="table border">
                                                <tbody>
                                                    <tr>
                                                        <td class="py-3">Discount</td>
                                                        <td class="py-3">
                                                            <input type="number" id="discount" name="discount"
                                                                class="form-control" value="{{ $editData->discount ?? 0 }}"
                                                                min="0">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="py-3 text-primary">Grand Total</td>
                                                        <td class="py-3 text-primary" id="grandTotal">TK
                                                            {{ number_format($editData->grand_total ?? 0, 2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="form-label">Notes:</label>
                                <textarea class="form-control" name="notes" rows="3">{{ $editData->notes }}</textarea>
                            </div>

                            <div class="col-xl-12">
                                <div class="d-flex mt-5 justify-content-end">
                                    <button class="btn btn-primary me-3" type="submit">Update</button>
                                    <a class="btn btn-secondary" href="{{ route('all.quotation') }}">Cancel</a>
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
                const searchUrl = "{{ route('quotation.product.search') }}";
                const searchInput = document.getElementById('product_search');
                const productList = document.getElementById('product_list');
                const productBody = document.getElementById('productBody');

                function formatUnitPrice(product) {
                    const p = parseFloat(product.unit_price);
                    return (isNaN(p) ? 0 : p).toFixed(2);
                }

                function renderSearchResults(products) {
                    productList.innerHTML = '';
                    products.forEach((product) => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = product.code + ' - ' + product.name + ' (Stock: ' + product.stock +
                            ') · TK ' + formatUnitPrice(product);
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

                    const unitPrice = formatUnitPrice(product);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <input type="text" class="form-control" value="${product.code} - ${product.name}" readonly>
                            <input type="hidden" name="products[${product.id}][id]" value="${product.id}">
                        </td>
                        <td>
                            <input type="number" class="form-control text-end" name="products[${product.id}][price]" value="${unitPrice}" min="0" step="0.01" style="max-width: 120px;">
                        </td>
                        <td>
                            <input type="number" class="form-control text-center" name="products[${product.id}][quantity]" value="1" min="1" style="max-width: 80px;">
                        </td>
                        <td class="text-end">TK <span class="item-total">0.00</span></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-item"><span class="mdi mdi-delete-circle mdi-18px"></span></button></td>
                    `;
                    productBody.appendChild(row);

                    const priceInput = row.querySelector('input[name$="[price]"]');
                    const qtyInput = row.querySelector('input[name$="[quantity]"]');
                    const totalSpan = row.querySelector('.item-total');

                    function updateTotal() {
                        const price = parseFloat(priceInput.value) || 0;
                        const qty = parseFloat(qtyInput.value) || 0;
                        const total = price * qty;
                        totalSpan.textContent = total.toFixed(2);
                        updateGrandTotal();
                    }

                    priceInput.addEventListener('input', updateTotal);
                    qtyInput.addEventListener('input', updateTotal);
                    updateTotal();
                }

                function updateGrandTotal() {
                    let grandTotal = 0;
                    productBody.querySelectorAll('tr').forEach(row => {
                        const price = parseFloat(row.querySelector('input[name$="[price]"]')?.value) || 0;
                        const qty = parseFloat(row.querySelector('input[name$="[quantity]"]')?.value) || 0;
                        grandTotal += price * qty;
                    });

                    const discount = parseFloat(document.getElementById('discount')?.value) || 0;
                    grandTotal -= discount;

                    document.getElementById('grandTotal').textContent = 'TK ' + grandTotal.toFixed(2);
                }

                // Initialize existing items (line total + grand total on change)
                productBody.querySelectorAll('tr').forEach(row => {
                    const priceInput = row.querySelector('input[name$="[price]"]');
                    const qtyInput = row.querySelector('input[name$="[quantity]"]');
                    const totalSpan = row.querySelector('.item-total');
                    if (priceInput && qtyInput && totalSpan) {
                        const syncRow = () => {
                            const price = parseFloat(priceInput.value) || 0;
                            const qty = parseFloat(qtyInput.value) || 0;
                            totalSpan.textContent = (price * qty).toFixed(2);
                            updateGrandTotal();
                        };
                        priceInput.addEventListener('input', syncRow);
                        qtyInput.addEventListener('input', syncRow);
                    }
                });

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
                        updateGrandTotal();
                    }
                });

                document.getElementById('discount')?.addEventListener('input', updateGrandTotal);
            });
        </script>
    @endpush
@endsection
