@extends('admin.admin_master')
@section('admin')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('stockFilterForm');
                const tbody = document.querySelector('#stockTable tbody');
                const endpoint = "{{ route('filter-stock') }}";

                if (!form || !tbody) {
                    return;
                }

                var products = @json($products);
                var prices = @json($prices);
                var currentFilters = {
                    subcategory_id: '',
                    brand_id: '',
                    product_id: '',
                    stock_less_than: ''
                };

                function getStockThreshold() {
                    var input = document.getElementById('stock_less_than');
                    if (!input || input.value === '') {
                        return 10;
                    }
                    var n = parseFloat(input.value);
                    if (isNaN(n) || n <= 0) {
                        return 10;
                    }
                    return n;
                }

                function stockStatusFromThreshold(qty, threshold) {
                    var q = parseFloat(qty);
                    var n = parseFloat(threshold);
                    if (isNaN(q)) {
                        q = 0;
                    }
                    if (isNaN(n) || n <= 0) {
                        n = 10;
                    }
                    if (q === 0) {
                        return {
                            text: 'Out of Stock',
                            statusClass: 'bg-danger',
                            qtyClass: 'bg-danger'
                        };
                    }
                    // N = your number: qty < N → Low Stock, qty > N → Available, qty == N → Low Stock
                    if (q > n) {
                        return {
                            text: 'Available',
                            statusClass: 'bg-success',
                            qtyClass: 'bg-success'
                        };
                    }
                    return {
                        text: 'Low Stock',
                        statusClass: 'bg-warning text-dark',
                        qtyClass: 'bg-warning text-dark'
                    };
                }

                // Initialize select2
                const initSelect2 = () => {
                    if (typeof $.fn.select2 !== 'undefined') {
                        $('.select2').select2({
                            allowClear: true,
                            placeholder: 'Select Option',
                            width: '100%'
                        });
                    }
                };
                initSelect2();

                // Handle form submission
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(form);
                    currentFilters.subcategory_id = formData.get('subcategory_id') || '';
                    currentFilters.brand_id = formData.get('brand_id') || '';
                    currentFilters.product_id = formData.get('product_id') || '';
                    currentFilters.stock_less_than = formData.get('stock_less_than') || '';
                    fetchFilteredData();
                });

                // Print function
                window.printStockTable = function() {
                    var today = new Date().toISOString().split('T')[0];

                    var filterParts = [];
                    if (currentFilters.subcategory_id) {
                        var subcatText = document.querySelector('#filter_subcategory option[value="' +
                            currentFilters.subcategory_id + '"]');
                        if (subcatText) filterParts.push('Subcategory: ' + subcatText.textContent.trim());
                    }
                    if (currentFilters.brand_id) {
                        var brandText = document.querySelector('#filter_brand option[value="' + currentFilters
                            .brand_id + '"]');
                        if (brandText) filterParts.push('Brand: ' + brandText.textContent.trim());
                    }
                    if (currentFilters.product_id) {
                        var prodText = document.querySelector('#filter_product option[value="' + currentFilters
                            .product_id + '"]');
                        if (prodText) filterParts.push('Product: ' + prodText.textContent.trim());
                    }
                    if (currentFilters.stock_less_than !== '') {
                        filterParts.push('Stock less than (threshold): ' + currentFilters.stock_less_than);
                    }

                    var filterSummary = filterParts.length > 0 ? filterParts.join(' | ') : 'All Records';

                    var tableHTML = '<table style="width:100%; border-collapse: collapse;">';
                    tableHTML += '<thead><tr>' +
                        '<th>SL</th>' +
                        '<th>Product</th>' +
                        '<th>Category</th>' +
                        '<th>SubCategory</th>' +
                        '<th>Brand</th>' +
                        '<th>Quantity</th>' +
                        '<th>Unit Price</th>' +
                        '<th>Stock Value</th>' +
                        '<th>Status</th>' +
                        '</tr></thead><tbody>';

                    var totalQty = 0;
                    var totalValue = 0;

                    var printThreshold = getStockThreshold();

                    for (var i = 0; i < products.length; i++) {
                        var p = products[i];
                        var qty = parseFloat(p.product_qty) || 0;
                        var price = prices[p.id] ? parseFloat(prices[p.id].net_unit_cost) : 0;
                        var value = qty * price;

                        var st = stockStatusFromThreshold(qty, printThreshold);
                        var status = st.text;
                        var statusClass = st.statusClass;
                        var qtyBadge = st.qtyClass;
                        tableHTML += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + (p.name || '-') + '</td>' +
                            '<td>' + (p.category ? p.category.category_name : '-') + '</td>' +
                            '<td>' + (p.subcategory ? p.subcategory.subcategory_name : '-') + '</td>' +
                            '<td>' + (p.brand ? p.brand.name : '-') + '</td>' +
                            '<td><span class="badge ' + qtyBadge + '">' + qty + '</span></td>' +
                            '<td>' + price.toFixed(2) + '</td>' +
                            '<td>' + value.toFixed(2) + '</td>' +
                            '<td><span class="badge ' + statusClass + '">' + status + '</span></td>' +
                            '</tr>';

                        totalQty += qty;
                        totalValue += value;
                    }

                    tableHTML += '</tbody></table>';

                    var printWindow = window.open('', '', 'height=800,width=1000');
                    printWindow.document.write('<html><head><title>Stock Report</title>');
                    printWindow.document.write('<style>');
                    printWindow.document.write('body { font-family: Arial, sans-serif; padding: 20px; }');
                    printWindow.document.write('.text-center { text-align: center; }');
                    printWindow.document.write('.mb-4 { margin-bottom: 20px; }');
                    printWindow.document.write('.mb-1 { margin-bottom: 5px; }');
                    printWindow.document.write('.mb-0 { margin-bottom: 0; }');
                    printWindow.document.write('.filter-info { margin-top: 10px; font-size: 14px; color: #555; }');
                    printWindow.document.write('img { width: 80px; }');
                    printWindow.document.write('h2 { margin: 10px 0 5px; }');
                    printWindow.document.write(
                        'table { width: 100%; border-collapse: collapse; margin-top: 20px; }');
                    printWindow.document.write(
                        'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
                    printWindow.document.write('th { background-color: #f2f2f2; }');
                    printWindow.document.write('</style>');
                    printWindow.document.write('</head><body>');
                    printWindow.document.write('<div class="text-center mb-4">');
                    printWindow.document.write(
                        '<img src="{{ asset('backend/assets/images/bubt.png') }}" alt="BUBT Logo">');
                    printWindow.document.write('<h2 class="mb-1">Stock Report</h2>');
                    printWindow.document.write('<p class="mb-0">Date: ' + today + '</p>');
                    printWindow.document.write('<p class="filter-info">Filters: ' + filterSummary + '</p>');
                    printWindow.document.write('</div>');
                    printWindow.document.write(tableHTML);

                    printWindow.document.write('<div style="margin-top: 20px; text-align: right;">');
                    printWindow.document.write(
                        '<table style="width: 320px; margin-left: auto; border-collapse: collapse;">');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Items</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">' +
                        products.length + '</td></tr>');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Quantity</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">' +
                        totalQty + '</td></tr>');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Value</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">TK ' +
                        totalValue.toFixed(2) + '</td></tr>');
                    printWindow.document.write('</table></div>');

                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    printWindow.print();
                };

                function fetchFilteredData() {
                    const params = new URLSearchParams(new FormData(form));

                    fetch(endpoint + '?' + params.toString(), {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            updateTable(data.products || [], data.prices || {}, data.stock_threshold);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function updateTable(data, newPrices, stockThresholdFromServer) {
                    products = data;
                    if (newPrices) {
                        prices = newPrices;
                    }
                    tbody.innerHTML = '';
                    let sl = 1;
                    let totalQty = 0;
                    let totalValue = 0;

                    if (!products.length) {
                        tbody.innerHTML =
                            '<tr><td colspan="9" class="text-center">No stock data found for selected filters.</td></tr>';
                        document.getElementById('totalItems').textContent = '0';
                        document.getElementById('totalQty').textContent = '0';
                        document.getElementById('totalValue').textContent = '0.00';
                        return;
                    }

                    var tableThreshold = stockThresholdFromServer;
                    if (tableThreshold === undefined || tableThreshold === null || tableThreshold === '') {
                        tableThreshold = getStockThreshold();
                    } else {
                        var parsed = parseFloat(tableThreshold);
                        tableThreshold = (isNaN(parsed) || parsed <= 0) ? getStockThreshold() : parsed;
                    }

                    products.forEach(product => {
                        const qty = parseFloat(product.product_qty) || 0;
                        const price = prices[product.id] ? parseFloat(prices[product.id].net_unit_cost) : 0;
                        const value = qty * price;

                        const st = stockStatusFromThreshold(qty, tableThreshold);
                        const status = st.text;
                        const statusClass = st.statusClass;
                        const qtyClass = st.qtyClass;

                        const row = '<tr>' +
                            '<td>' + sl + '</td>' +
                            '<td>' + (product.name || '-') + '</td>' +
                            '<td>' + (product.category ? product.category.category_name : '-') + '</td>' +
                            '<td>' + (product.subcategory ? product.subcategory.subcategory_name : '-') +
                            '</td>' +
                            '<td>' + (product.brand ? product.brand.name : '-') + '</td>' +
                            '<td><span class="badge ' + qtyClass + '">' + qty + '</span></td>' +
                            '<td>' + price.toFixed(2) + '</td>' +
                            '<td>' + value.toFixed(2) + '</td>' +
                            '<td><span class="badge ' + statusClass + '">' + status + '</span></td>' +
                            '</tr>';
                        tbody.insertAdjacentHTML('beforeend', row);
                        sl++;
                        totalQty += qty;
                        totalValue += value;
                    });

                    document.getElementById('totalItems').textContent = products.length;
                    document.getElementById('totalQty').textContent = totalQty;
                    document.getElementById('totalValue').textContent = totalValue.toFixed(2);
                }
            });
        </script>
    @endpush

    <div class="page-content m-2">
        <div class="container">
            {{-- @include('admin.backend.report.body.report_top') --}}
        </div>

        <div class="card pt-3">
            <div class="container-fluid">
                <form id="stockFilterForm" action="javascript:void(0);">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_subcategory" class="form-label">Subcategory</label>
                            <select id="filter_subcategory" name="subcategory_id" class="form-control large-select select2"
                                data-placeholder="Subcategory">
                                <option value="" selected>All Subcategories</option>
                                @forelse($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_brand" class="form-label">Brand</label>
                            <select id="filter_brand" name="brand_id" class="form-control large-select select2"
                                data-placeholder="Brand">
                                <option value="" selected>All Brands</option>
                                @forelse($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_product" class="form-label">Product</label>
                            <select id="filter_product" name="product_id" class="form-control large-select select2"
                                data-placeholder="Product">
                                <option value="" selected>All Products</option>
                                @forelse($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="stock_less_than" class="form-label">Stock less than</label>
                            <input type="number" name="stock_less_than" id="stock_less_than" min="1" step="1"
                                class="form-control" placeholder="e.g. 20 — qty below = Low, qty above = Available">
                        </div>

                        {{-- <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="stock_type" class="form-label">Stock Type</label>
                            <select id="stock_type" name="stock_type" class="form-control large-select select2">
                                <option value="">All Stock</option>
                                <option value="low_stock">Low Stock (≤10)</option>
                                <option value="out_stock">Out of Stock</option>
                                <option value="available">Available</option>
                            </select>
                        </div> --}}

                        <div class="col-lg-4 col-md-6 col-12 mt-3 mb-3">
                            <button type="submit" class="btn btn-primary">Filter Stock</button>
                            <button type="button" class="btn btn-success ms-2" onclick="printStockTable()">Print</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div class="text-center mb-4 print-header">
                    <img src="{{ asset('backend/assets/images/bubt.png') }}" alt="BUBT Logo"
                        style="width: 80px; height: auto; margin-bottom: 10px;">
                    <h2 class="mb-1">Stock Report</h2>
                    <p class="mb-0">Date: {{ date('Y-m-d') }}</p>
                </div>

                <div class="table-responsive">
                    <div id="stockTable_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="stockTable" class="table table-striped table-bordered dataTable"
                                    style="width: 100%;" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th>SL</th>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>SubCategory</th>
                                            <th>Brand</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Stock Value</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $stockThreshold = 10.0;
                                        @endphp
                                        @foreach ($products as $key => $product)
                                            @php
                                                $unitPrice = isset($prices[$product->id])
                                                    ? $prices[$product->id]->net_unit_cost
                                                    : 0;
                                                $qty = (float) ($product->product_qty ?? 0);
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $product->name ?? '-' }}</td>
                                                <td>{{ $product->category->category_name ?? '-' }}</td>
                                                <td>{{ $product->subcategory->subcategory_name ?? '-' }}</td>
                                                <td>{{ $product->brand->name ?? '-' }}</td>
                                                <td>
                                                    @if ($qty == 0)
                                                        <span class="badge bg-danger">0</span>
                                                    @elseif ($qty > $stockThreshold)
                                                        <span class="badge bg-success">{{ $qty }}</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning text-dark">{{ $qty }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ number_format($unitPrice, 2) }}</td>
                                                <td>{{ number_format(($product->product_qty ?? 0) * $unitPrice, 2) }}
                                                </td>
                                                <td>
                                                    @if ($qty == 0)
                                                        <span class="badge bg-danger">Out of Stock</span>
                                                    @elseif ($qty > $stockThreshold)
                                                        <span class="badge bg-success">Available</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Low Stock</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @php
                                    $totalItems = $products->count();
                                    $totalQty = $products->sum('product_qty');
                                    $totalValue = $products->sum(function ($p) use ($prices) {
                                        $unitPrice = isset($prices[$p->id]) ? $prices[$p->id]->net_unit_cost : 0;
                                        return ($p->product_qty ?? 0) * $unitPrice;
                                    });
                                @endphp

                                <div class="mt-3" style="text-align: right;">
                                    <table style="width:320px; margin-left: auto;" class="table table-bordered">
                                        <tr>
                                            <td><strong>Total Items</strong></td>
                                            <td class="text-end" id="totalItems">{{ $totalItems }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Quantity</strong></td>
                                            <td class="text-end" id="totalQty">{{ $totalQty }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Value</strong></td>
                                            <td class="text-end" id="totalValue">TK
                                                {{ number_format($totalValue ?? 0, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .large-select {
            width: 100%;
        }

        @media print {

            .btn,
            .action-column {
                display: none !important;
            }

            .print-header {
                display: block !important;
                text-align: center;
            }

            .print-header img {
                width: 60px;
            }
        }
    </style>
@endsection
