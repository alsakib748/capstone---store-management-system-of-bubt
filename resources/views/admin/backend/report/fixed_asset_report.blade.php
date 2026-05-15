@extends('admin.admin_master')
@section('admin')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('assetFilterForm');
                const tbody = document.querySelector('#assetTable tbody');
                const endpoint = "{{ route('filter-fixed-asset') }}";

                if (!form || !tbody) {
                    return;
                }

                var purchaseData = @json($purchaseData);
                var currentFilters = {
                    subcategory_id: '',
                    brand_id: '',
                    product_id: '',
                    sort_by: ''
                };

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
                    currentFilters.sort_by = formData.get('sort_by') || '';
                    fetchFilteredData();
                });

                // Print function
                window.printAssetTable = function() {
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
                    if (currentFilters.sort_by) {
                        var sortText = {
                            'latest': 'Latest First',
                            'oldest': 'Oldest First',
                            'name_asc': 'Name (A-Z)',
                            'name_desc': 'Name (Z-A)',
                            'qty_asc': 'Qty Low → High',
                            'qty_desc': 'Qty High → Low'
                        };
                        filterParts.push('Sort: ' + (sortText[currentFilters.sort_by] || currentFilters
                            .sort_by));
                    }

                    var filterSummary = filterParts.length > 0 ? filterParts.join(' | ') : 'All Records';

                    var tableHTML = '<table style="width:100%; border-collapse: collapse;">';
                    tableHTML += '<thead><tr>' +
                        '<th>SL</th>' +
                        '<th>Product</th>' +
                        '<th>Category</th>' +
                        '<th>Brand</th>' +
                        '<th>Qty</th>' +
                        '<th>Original Price</th>' +
                        '<th>Current Price</th>' +
                        '<th>Depreciation</th>' +
                        '<th>Stock Value</th>' +
                        '<th>Remaining Days</th>' +
                        '</tr></thead><tbody>';

                    var totalQty = 0;
                    var totalOriginal = 0;
                    var totalCurrent = 0;
                    var totalDepreciation = 0;

                    for (var i = 0; i < purchaseData.length; i++) {
                        var item = purchaseData[i];
                        totalQty += item.quantity;
                        totalOriginal += item.original_price * item.quantity;
                        totalCurrent += Number(item.stock_value) || 0;
                        totalDepreciation += item.depreciation * item.quantity;

                        var statusClass = item.remaining_days <= 10 ? 'bg-danger' : (item.remaining_days <= 30 ?
                            'bg-warning text-dark' : 'bg-success');
                        if (item.remaining_days <= 0) statusClass = 'bg-secondary';

                        tableHTML += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + (item.product_name || '-') + '</td>' +
                            '<td>' + (item.category || '-') + '</td>' +
                            '<td>' + (item.brand || '-') + '</td>' +
                            '<td>' + item.quantity + '</td>' +
                            '<td>' + item.original_price.toFixed(2) + '</td>' +
                            '<td>' + (Math.floor(Number(item.current_price) || 0)).toLocaleString('en-US') + '</td>' +
                            '<td>' + item.depreciation.toFixed(2) + '</td>' +
                            '<td>' + (Number(item.stock_value) || 0).toLocaleString('en-US') + '</td>' +
                            '<td><span class="badge ' + statusClass + '">' + item.remaining_days + '</span></td>' +
                            '</tr>';
                    }

                    tableHTML += '</tbody></table>';

                    var printWindow = window.open('', '', 'height=800,width=1200');
                    printWindow.document.write('<html><head><title>Fixed Asset Report</title>');
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
                        'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }');
                    printWindow.document.write('th { background-color: #f2f2f2; }');
                    printWindow.document.write('</style>');
                    printWindow.document.write('</head><body>');
                    printWindow.document.write('<div class="text-center mb-4">');
                    printWindow.document.write(
                        '<img src="{{ asset('backend/assets/images/bubt.png') }}" alt="BUBT Logo">');
                    printWindow.document.write('<h2 class="mb-1">Fixed Asset Report</h2>');
                    printWindow.document.write('<p class="mb-0">Date: ' + today + '</p>');
                    printWindow.document.write('<p class="filter-info">Filters: ' + filterSummary + '</p>');
                    printWindow.document.write('</div>');
                    printWindow.document.write(tableHTML);

                    printWindow.document.write('<div style="margin-top: 20px; text-align: right;">');
                    printWindow.document.write(
                        '<table style="width: 350px; margin-left: auto; border-collapse: collapse;">');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Quantity</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">' +
                        totalQty + '</td></tr>');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Original Value</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">TK ' +
                        totalOriginal.toFixed(2) + '</td></tr>');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Current Value</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">TK ' +
                        Math.round(totalCurrent).toLocaleString('en-US') + '</td></tr>');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Depreciation</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">TK ' +
                        totalDepreciation.toFixed(2) + '</td></tr>');
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
                            updateTable(data.purchaseData || []);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function updateTable(data) {
                    purchaseData = data;
                    tbody.innerHTML = '';
                    let sl = 1;
                    let totalQty = 0;
                    let totalOriginal = 0;
                    let totalCurrent = 0;
                    let totalDepreciation = 0;

                    if (!purchaseData.length) {
                        tbody.innerHTML =
                            '<tr><td colspan="10" class="text-center">No fixed asset data found for selected filters.</td></tr>';
                        document.getElementById('totalItems').textContent = '0';
                        document.getElementById('totalQty').textContent = '0';
                        document.getElementById('totalOriginal').textContent = '0.00';
                        document.getElementById('totalCurrent').textContent = 'TK 0';
                        document.getElementById('totalDepreciation').textContent = '0.00';
                        return;
                    }

                    purchaseData.forEach(item => {
                        totalQty += item.quantity;
                        totalOriginal += item.original_price * item.quantity;
                        totalCurrent += Number(item.stock_value) || 0;
                        totalDepreciation += item.depreciation * item.quantity;

                        let statusClass = item.remaining_days <= 10 ? 'bg-danger' : (item.remaining_days <= 30 ?
                            'bg-warning text-dark' : 'bg-success');
                        if (item.remaining_days <= 0) statusClass = 'bg-secondary';

                        const row = '<tr>' +
                            '<td>' + sl + '</td>' +
                            '<td>' + (item.product_name || '-') + '</td>' +
                            '<td>' + (item.category || '-') + '</td>' +
                            '<td>' + (item.brand || '-') + '</td>' +
                            '<td>' + item.quantity + '</td>' +
                            '<td>' + item.original_price.toFixed(2) + '</td>' +
                            '<td>' + (Math.floor(Number(item.current_price) || 0)).toLocaleString('en-US') + '</td>' +
                            '<td>' + item.depreciation.toFixed(2) + '</td>' +
                            '<td>' + (Number(item.stock_value) || 0).toLocaleString('en-US') + '</td>' +
                            '<td><span class="badge ' + statusClass + '">' + item.remaining_days +
                            '</span></td>' +
                            '</tr>';
                        tbody.insertAdjacentHTML('beforeend', row);
                        sl++;
                    });

                    document.getElementById('totalItems').textContent = purchaseData.length;
                    document.getElementById('totalQty').textContent = totalQty;
                    document.getElementById('totalOriginal').textContent = totalOriginal.toFixed(2);
                    document.getElementById('totalCurrent').textContent =
                        'TK ' + Math.round(totalCurrent).toLocaleString('en-US');
                    document.getElementById('totalDepreciation').textContent = totalDepreciation.toFixed(2);
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
                <form id="assetFilterForm" action="javascript:void(0);">
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
                            <label for="sort_by" class="form-label">Sort By</label>
                            <select id="sort_by" name="sort_by" class="form-control large-select select2">
                                <option value="">Default</option>
                                <option value="latest">Latest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="name_asc">Name (A-Z)</option>
                                <option value="name_desc">Name (Z-A)</option>
                                <option value="qty_asc">Qty Low → High</option>
                                <option value="qty_desc">Qty High → Low</option>
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mt-3 mb-3">
                            <button type="submit" class="btn btn-primary">Filter Fixed Asset</button>
                            <button type="button" class="btn btn-success ms-2" onclick="printAssetTable()">Print</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div class="text-center mb-4 print-header">
                    <img src="{{ asset('backend/assets/images/bubt.png') }}" alt="BUBT Logo"
                        style="width: 80px; height: auto; margin-bottom: 10px;">
                    <h2 class="mb-1">Fixed Asset Report</h2>
                    <p class="mb-0">Date: {{ date('Y-m-d') }}</p>
                </div>

                <div class="table-responsive">
                    <div id="assetTable_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="assetTable" class="table table-striped table-bordered dataTable"
                                    style="width: 100%;" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th>SL</th>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Qty</th>
                                            <th>Original Price</th>
                                            <th>Current Price</th>
                                            <th>Depreciation</th>
                                            <th>Stock Value</th>
                                            <th>Remaining Days</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchaseData as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item['product_name'] ?? '-' }}</td>
                                                <td>{{ $item['category'] ?? '-' }}</td>
                                                <td>{{ $item['brand'] ?? '-' }}</td>
                                                <td>{{ $item['quantity'] ?? 0 }}</td>
                                                <td>{{ number_format($item['original_price'] ?? 0, 2) }}</td>
                                                <td>{{ number_format((int) floor((float) ($item['current_price'] ?? 0)), 0, '.', ',') }}</td>
                                                <td>{{ number_format($item['depreciation'] ?? 0, 2) }}</td>
                                                <td>{{ number_format((int) ($item['stock_value'] ?? 0), 0, '.', ',') }}</td>
                                                <td>
                                                    @php
                                                        $remaining = $item['remaining_days'] ?? 0;
                                                        if ($remaining <= 0) {
                                                            $badgeClass = 'bg-secondary';
                                                        } elseif ($remaining <= 10) {
                                                            $badgeClass = 'bg-danger';
                                                        } elseif ($remaining <= 30) {
                                                            $badgeClass = 'bg-warning text-dark';
                                                        } else {
                                                            $badgeClass = 'bg-success';
                                                        }
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }}">{{ $remaining }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @php
                                    $totalItems = $purchaseData->count();
                                    $totalQty = $purchaseData->sum('quantity');
                                    $totalOriginal = $purchaseData->sum(function ($item) {
                                        return ($item['original_price'] ?? 0) * ($item['quantity'] ?? 0);
                                    });
                                    $totalCurrent = $purchaseData->sum(function ($item) {
                                        return (int) ($item['stock_value'] ?? 0);
                                    });
                                    $totalDepreciation = $purchaseData->sum(function ($item) {
                                        return ($item['depreciation'] ?? 0) * ($item['quantity'] ?? 0);
                                    });
                                @endphp

                                <div class="mt-3" style="text-align: right;">
                                    <table style="width:350px; margin-left: auto;" class="table table-bordered">
                                        <tr>
                                            <td><strong>Total Items</strong></td>
                                            <td class="text-end" id="totalItems">{{ $totalItems }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Quantity</strong></td>
                                            <td class="text-end" id="totalQty">{{ $totalQty }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Original Value</strong></td>
                                            <td class="text-end" id="totalOriginal">TK
                                                {{ number_format($totalOriginal ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Current Value</strong></td>
                                            <td class="text-end" id="totalCurrent">TK
                                                {{ number_format((int) ($totalCurrent ?? 0), 0, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Depreciation</strong></td>
                                            <td class="text-end" id="totalDepreciation">TK
                                                {{ number_format($totalDepreciation ?? 0, 2) }}</td>
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
