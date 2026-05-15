@extends('admin.admin_master')
@section('admin')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('issueReturnFilterForm');
                const tbody = document.querySelector('#issueReturnTable tbody');
                const endpoint = "{{ route('filter.issue.return') }}";
                var issueReturns = {!! json_encode($issueReturns->toArray()) !!};
                var latestPrices = {!! json_encode($latestPrices->toArray()) !!};

                if (!form || !tbody) {
                    return;
                }

                // Store current filter values
                var currentFilters = {
                    from_date: '',
                    to_date: '',
                    user_id: '',
                    created_by: '',
                    product_id: ''
                };

                // Handle form submission
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(form);
                    currentFilters.from_date = formData.get('from_date') || '';
                    currentFilters.to_date = formData.get('to_date') || '';
                    currentFilters.user_id = formData.get('user_id') || '';
                    currentFilters.created_by = formData.get('created_by') || '';
                    currentFilters.product_id = formData.get('product_id') || '';
                    fetchFilteredData();
                });

                // Initialize totals on page load
                updateSummaryDisplay();

                // Print function
                window.printTable = function() {
                    var today = new Date().toISOString().split('T')[0];

                    // Build filter summary string
                    var filterParts = [];
                    if (currentFilters.from_date || currentFilters.to_date) {
                        var dateRange = '';
                        if (currentFilters.from_date) dateRange += 'From: ' + currentFilters.from_date;
                        if (currentFilters.to_date) dateRange += ' To: ' + currentFilters.to_date;
                        if (dateRange) filterParts.push(dateRange);
                    }
                    if (currentFilters.user_id) {
                        var userText = document.querySelector('#filter_user option[value="' + currentFilters
                            .user_id + '"]');
                        if (userText) filterParts.push('User: ' + userText.textContent.trim());
                    }
                    if (currentFilters.created_by) {
                        var createdText = document.querySelector('#filter_created_by option[value="' +
                            currentFilters.created_by + '"]');
                        if (createdText) filterParts.push('Created By: ' + createdText.textContent.trim());
                    }
                    if (currentFilters.product_id) {
                        var prodText = document.querySelector('#filter_product option[value="' + currentFilters
                            .product_id + '"]');
                        if (prodText) filterParts.push('Product: ' + prodText.textContent.trim());
                    }

                    var filterSummary = filterParts.length > 0 ? filterParts.join(' | ') : 'All Records';

                    // Build table HTML
                    var tableHTML = '<table style="width:100%; border-collapse: collapse;">';
                    tableHTML += '<thead><tr>' +
                        '<th>SL</th>' +
                        '<th>Return Date</th>' +
                        '<th>Product</th>' +
                        '<th>Returned By</th>' +
                        '<th>Original Issue</th>' +
                        '<th>Received By</th>' +
                        '<th>Qty</th>' +
                        '<th>Condition</th>' +
                        '<th>Unit Price</th>' +
                        '<th>Total Value</th>' +
                        '</tr></thead><tbody>';

                    var totalItems = 0;
                    var totalQty = 0;
                    var grandTotal = 0;

                    for (var i = 0; i < (issueReturns.length || 0); i++) {
                        var issueReturn = issueReturns[i];
                        var items = issueReturn.issue_return_items || [];

                        for (var j = 0; j < items.length; j++) {
                            totalItems++;
                            var item = items[j];
                            var qty = parseFloat(item.qty) || 0;
                            var productId = item.product_id || (item.product ? item.product.id : null);
                            var price = productId && latestPrices[productId] ? parseFloat(latestPrices[productId]
                                .net_unit_cost) || 0 : 0;
                            var totalValue = qty * price;

                            var productName = item.product ? item.product.name : '-';
                            var userName = issueReturn.user ? issueReturn.user.name : '-';
                            var issueNo = issueReturn.issue ? issueReturn.issue.tracking_no : '-';
                            var createdByName = (issueReturn.createdBy || issueReturn.created_by) ? (issueReturn
                                .createdBy || issueReturn.created_by).name : '-';

                            tableHTML += '<tr>' +
                                '<td>' + totalItems + '</td>' +
                                '<td>' + (issueReturn.return_date || 'N/A') + '</td>' +
                                '<td>' + productName + '</td>' +
                                '<td>' + userName + '</td>' +
                                '<td>' + issueNo + '</td>' +
                                '<td>' + createdByName + '</td>' +
                                '<td>' + qty + '</td>' +
                                '<td>' + (item.condition || '-') + '</td>' +
                                '<td>TK ' + price.toFixed(2) + '</td>' +
                                '<td>TK ' + totalValue.toFixed(2) + '</td>' +
                                '</tr>';

                            totalQty += qty;
                            grandTotal += totalValue;
                        }
                    }

                    tableHTML += '</tbody></table>';

                    var printWindow = window.open('', '', 'height=800,width=1000');
                    printWindow.document.write('<html><head><title>Issue Return Report</title>');
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
                    printWindow.document.write('<h2 class="mb-1">Issue Return Report</h2>');
                    printWindow.document.write('<p class="mb-0">Date: ' + today + '</p>');
                    printWindow.document.write('<p class="filter-info">Filters: ' + filterSummary + '</p>');
                    printWindow.document.write('</div>');
                    printWindow.document.write(tableHTML);

                    // Summary
                    printWindow.document.write('<div style="margin-top: 20px; text-align: right;">');
                    printWindow.document.write(
                        '<table style="width: 320px; margin-left: auto; border-collapse: collapse;">');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Items</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">' +
                        totalItems + '</td></tr>');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Qty</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">' +
                        totalQty + '</td></tr>');
                    printWindow.document.write(
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Grand Total</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">TK ' +
                        grandTotal.toFixed(2) + '</td></tr>');
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
                            latestPrices = data.latestPrices || {};
                            updateTable(data.issueReturns || []);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function updateTable(data) {
                    issueReturns = data || [];
                    tbody.innerHTML = '';
                    let sl = 1;

                    if (!issueReturns.length) {
                        tbody.innerHTML =
                            '<tr><td colspan="10" class="text-center">No data found for selected filters.</td></tr>';
                        return;
                    }

                    issueReturns.forEach(issueReturn => {
                        const items = issueReturn.issue_return_items || [];

                        items.forEach(item => {
                            const qty = parseFloat(item.qty) || 0;
                            const productId = item.product_id || (item.product ? item.product.id :
                            null);
                            const price = productId && latestPrices[productId] ? parseFloat(
                                latestPrices[productId].net_unit_cost) || 0 : 0;
                            const totalValue = qty * price;
                            const productName = item.product ? item.product.name : '-';

                            const conditionBadge = item.condition === 'good' ?
                                '<span class="badge bg-success">Good</span>' :
                                '<span class="badge bg-danger">Damaged</span>';

                            const row = '<tr>' +
                                '<td>' + sl + '</td>' +
                                '<td>' + (issueReturn.return_date || 'N/A') + '</td>' +
                                '<td>' + productName + '</td>' +
                                '<td>' + (issueReturn.user ? issueReturn.user.name : '-') + '</td>' +
                                '<td>' + (issueReturn.issue ? 'Issue #' + issueReturn.issue.id + ' (' +
                                    issueReturn.issue.date + ')' : '-') + '</td>' +
                                '<td>' + ((issueReturn.createdBy || issueReturn.created_by) ? (
                                    issueReturn.createdBy || issueReturn.created_by).name : '-') +
                                '</td>' +
                                '<td>' + qty + '</td>' +
                                '<td>' + conditionBadge + '</td>' +
                                '<td>TK ' + price.toFixed(2) + '</td>' +
                                '<td>TK ' + totalValue.toFixed(2) + '</td>' +
                                '</tr>';
                            tbody.insertAdjacentHTML('beforeend', row);
                            sl++;
                        });
                    });

                    updateSummaryDisplay();
                }

                function updateSummaryDisplay() {
                    var totalItems = 0;
                    var totalQty = 0;
                    var grandTotal = 0;

                    for (var i = 0; i < (issueReturns.length || 0); i++) {
                        var issueReturn = issueReturns[i];
                        var items = issueReturn.issue_return_items || [];
                        for (var j = 0; j < items.length; j++) {
                            totalItems++;
                            var qty = parseFloat(items[j].qty) || 0;
                            var productId = items[j].product_id || (items[j].product ? items[j].product.id : null);
                            var price = productId && latestPrices[productId] ? parseFloat(latestPrices[productId]
                                .net_unit_cost) || 0 : 0;
                            totalQty += qty;
                            grandTotal += qty * price;
                        }
                    }

                    var totalItemsDisplay = document.getElementById('totalItemsDisplay');
                    var totalQtyDisplay = document.getElementById('totalQtyDisplay');
                    var grandTotalDisplay = document.getElementById('grandTotalDisplay');

                    if (totalItemsDisplay) totalItemsDisplay.textContent = totalItems;
                    if (totalQtyDisplay) totalQtyDisplay.textContent = totalQty;
                    if (grandTotalDisplay) grandTotalDisplay.textContent = 'TK ' + grandTotal.toFixed(2);
                }
            });
        </script>
    @endpush

    <div class="page-content m-2">
        <div class="container"></div>

        <div class="card pt-3">
            <div class="container-fluid">
                <form id="issueReturnFilterForm" action="javascript:void(0);">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control" id="from_date">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" name="to_date" class="form-control" id="to_date">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_user" class="form-label">Returned By</label>
                            <select id="filter_user" name="user_id" class="form-control select2"
                                data-placeholder="Returned By">
                                <option value="" selected>All Returned By</option>
                                @forelse($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_created_by" class="form-label">Received By</label>
                            <select id="filter_created_by" name="created_by" class="form-control select2"
                                data-placeholder="Received By">
                                <option value="" selected>All</option>
                                @forelse($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_product" class="form-label">Product</label>
                            <select id="filter_product" name="product_id" class="form-control select2"
                                data-placeholder="Select Product">
                                <option value="" selected>All Products</option>
                                @forelse($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mt-3 mb-3">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <button type="button" class="btn btn-success ms-2" onclick="printTable()">Print</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div class="text-center mb-4 print-header">
                    <img src="{{ asset('backend/assets/images/bubt.png') }}" alt="BUBT Logo"
                        style="width: 80px; height: auto; margin-bottom: 10px;">
                    <h2 class="mb-1">Issue Return Report</h2>
                    <p class="mb-0">Date: {{ date('Y-m-d') }}</p>
                </div>

                <div class="table-responsive">
                    <table id="issueReturnTable" class="table table-striped table-bordered dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Return Date</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Original Issue</th>
                                <th>Created By</th>
                                <th>Qty</th>
                                <th>Condition</th>
                                <th>Unit Price</th>
                                <th>Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issueReturns as $key => $issueReturn)
                                @foreach ($issueReturn->issueReturnItems as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($issueReturn->return_date)->format('Y-m-d') }}</td>
                                        <td>{{ $item->product->name ?? '-' }}</td>
                                        <td>{{ $issueReturn->user?->name ?? '-' }}</td>
                                        <td>{{ $issueReturn->issue ? 'Issue #' . $issueReturn->issue->id . ' (' . \Carbon\Carbon::parse($issueReturn->issue->date)->format('Y-m-d') . ')' : '-' }}
                                        </td>
                                        <td>{{ $issueReturn->createdBy?->name ?? '-' }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>
                                            @if ($item->condition == 'good')
                                                <span class="badge bg-success">Good</span>
                                            @else
                                                <span class="badge bg-danger">Damaged</span>
                                            @endif
                                        </td>
                                        <td>TK {{ number_format($latestPrices[$item->product_id]->net_unit_cost ?? 0, 2) }}
                                        </td>
                                        <td>TK
                                            {{ number_format($item->qty * ($latestPrices[$item->product_id]->net_unit_cost ?? 0), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                    @php
                        $totalItems = collect($issueReturns)->reduce(function ($carry, $issueReturn) {
                            return $carry +
                                ($issueReturn->issueReturnItems ? $issueReturn->issueReturnItems->count() : 0);
                        }, 0);
                        $totalQty = collect($issueReturns)->reduce(function ($carry, $issueReturn) {
                            return $carry +
                                ($issueReturn->issueReturnItems ? $issueReturn->issueReturnItems->sum('qty') : 0);
                        }, 0);
                        $grandTotal = collect($issueReturns)->reduce(function ($carry, $issueReturn) use (
                            $latestPrices,
                        ) {
                            $total = 0;
                            if ($issueReturn->issueReturnItems) {
                                foreach ($issueReturn->issueReturnItems as $item) {
                                    $price = isset($latestPrices[$item->product_id])
                                        ? $latestPrices[$item->product_id]->net_unit_cost
                                        : 0;
                                    $total += $item->qty * $price;
                                }
                            }
                            return $carry + $total;
                        }, 0);
                    @endphp

                    <div class="mt-3" style="text-align: right;">
                        <table style="width: 320px; margin-left: auto;" class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><strong>Total Items</strong></td>
                                    <td class="text-end" id="totalItemsDisplay">{{ $totalItems }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Qty</strong></td>
                                    <td class="text-end" id="totalQtyDisplay">{{ $totalQty }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Grand Total</strong></td>
                                    <td class="text-end" id="grandTotalDisplay">TK {{ number_format($grandTotal ?? 0, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {

            .btn,
            .action-column,
            td:last-child,
            th:last-child {
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
