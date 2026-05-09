@extends('admin.admin_master')
@section('admin')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('damageFilterForm');
                const tbody = document.querySelector('#damageTable tbody');
                const endpoint = "{{ route('filter-damage-products') }}";
                var damageProducts = {!! json_encode($damageProducts->toArray()) !!};
                var purchasePrices = {!! json_encode($latestPrices->toArray()) !!};

                if (!form || !tbody) {
                    return;
                }

                // Store current filter values
                var currentFilters = {
                    from_date: '',
                    to_date: '',
                    semester_id: '',
                    product_id: ''
                };

                // Store calculated totals for print
                var printTotals = {
                    totalItems: 0,
                    totalQty: 0,
                    grandTotal: 0
                };

                // Update print summary totals
                function updatePrintSummary() {
                    printTotals = {
                        totalItems: 0,
                        totalQty: 0,
                        grandTotal: 0
                    };

                    for (var i = 0; i < (damageProducts.length || 0); i++) {
                        var dp = damageProducts[i];
                        var items = dp.damage_product_item || dp.damageProductItem || [];
                        for (var j = 0; j < items.length; j++) {
                            printTotals.totalItems++;
                            var qty = parseFloat(items[j].qty) || 0;
                            var price = 0;
                            if (purchasePrices && items[j].product_id) {
                                var priceData = purchasePrices[items[j].product_id];
                                if (priceData) {
                                    price = parseFloat(priceData.net_unit_cost) || 0;
                                }
                            }
                            printTotals.totalQty += qty;
                            printTotals.grandTotal += qty * price;
                        }
                    }

                    // Update the summary display in the table
                    updateSummaryDisplay();
                }

                function updateSummaryDisplay() {
                    var totalItemsDisplay = document.getElementById('totalItemsDisplay');
                    var totalQtyDisplay = document.getElementById('totalQtyDisplay');
                    var grandTotalDisplay = document.getElementById('grandTotalDisplay');

                    if (totalItemsDisplay) {
                        totalItemsDisplay.textContent = printTotals.totalItems;
                    }
                    if (totalQtyDisplay) {
                        totalQtyDisplay.textContent = printTotals.totalQty;
                    }
                    if (grandTotalDisplay) {
                        grandTotalDisplay.textContent = 'TK ' + printTotals.grandTotal.toFixed(2);
                    }
                }

                // Handle form submission
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(form);
                    currentFilters.from_date = formData.get('from_date') || '';
                    currentFilters.to_date = formData.get('to_date') || '';
                    currentFilters.semester_id = formData.get('semester_id') || '';
                    currentFilters.product_id = formData.get('product_id') || '';
                    fetchFilteredData();
                });

                // Initialize totals on page load
                updatePrintSummary();

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
                    if (currentFilters.semester_id) {
                        var semesterText = document.querySelector('#filter_semester option[value="' + currentFilters
                            .semester_id + '"]');
                        if (semesterText) filterParts.push('Semester: ' + semesterText.textContent.trim());
                    }
                    if (currentFilters.product_id) {
                        var prodText = document.querySelector('#filter_product option[value="' + currentFilters
                            .product_id + '"]');
                        if (prodText) filterParts.push('Product: ' + prodText.textContent.trim());
                    }

                    var filterSummary = filterParts.length > 0 ? filterParts.join(' | ') : 'All Records';

                    // Build table from current data
                    var tableHTML = '<table style="width:100%; border-collapse: collapse;">';
                    tableHTML += '<thead><tr>' +
                        '<th>SL</th>' +
                        '<th>Date</th>' +
                        '<th>Product</th>' +
                        '<th>Quantity</th>' +
                        '<th>Unit Price</th>' +
                        '<th>Total Loss</th>' +
                        '<th>Note</th>' +
                        '</tr></thead><tbody>';

                    var totalItems = 0;
                    var totalQty = 0;
                    var grandTotal = 0;
                    var sl = 1;

                    for (var i = 0; i < (damageProducts.length || 0); i++) {
                        var dp = damageProducts[i];
                        var items = dp.damage_product_item || dp.damageProductItem || [];

                        for (var j = 0; j < items.length; j++) {
                            var item = items[j];
                            totalItems++;

                            var qty = parseFloat(item.qty) || 0;
                            var price = 0;
                            if (purchasePrices && item.product_id) {
                                var priceData = purchasePrices[item.product_id];
                                if (priceData) {
                                    price = parseFloat(priceData.net_unit_cost) || 0;
                                }
                            }
                            var totalLoss = qty * price;

                            var productName = item.product ? item.product.name : '-';
                            var noteText = dp.notes || dp.note || '-';

                            tableHTML += '<tr>' +
                                '<td>' + sl + '</td>' +
                                '<td>' + (dp.date || 'N/A') + '</td>' +
                                '<td>' + productName + '</td>' +
                                '<td>' + qty + '</td>' +
                                '<td>TK ' + parseFloat(price).toFixed(2) + '</td>' +
                                '<td>TK ' + totalLoss.toFixed(2) + '</td>' +
                                '<td>' + noteText + '</td>' +
                                '</tr>';

                            totalQty += qty;
                            grandTotal += totalLoss;
                            sl++;
                        }
                    }

                    tableHTML += '</tbody></table>';

                    var printWindow = window.open('', '', 'height=800,width=1000');
                    printWindow.document.write('<html><head><title>Damage Product Report</title>');
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
                    printWindow.document.write('<h2 class="mb-1">Damage Product Report</h2>');
                    printWindow.document.write('<p class="mb-0">Date: ' + today + '</p>');
                    printWindow.document.write('<p class="filter-info">Filters: ' + filterSummary + '</p>');
                    printWindow.document.write('</div>');
                    printWindow.document.write(tableHTML);

                    // Summary with totals
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
                        '<tr><td style="background:#f9f9f9;padding:8px;border:1px solid #ddd;"><strong>Total Loss</strong></td><td style="text-align:right;padding:8px;border:1px solid #ddd;">TK ' +
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
                            updateTable(data.damageProducts || [], data.purchasePrices || null);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function updateTable(data, prices) {
                    damageProducts = data || [];
                    if (prices) {
                        purchasePrices = prices;
                    }
                    // Update print summary display
                    updatePrintSummary();
                    tbody.innerHTML = '';
                    let sl = 1;

                    if (!damageProducts.length) {
                        tbody.innerHTML =
                            '<tr><td colspan="7" class="text-center">No damage product data found.</td></tr>';
                        return;
                    }

                    damageProducts.forEach(damage => {
                        const items = damage.damage_product_item || damage.damageProductItem || [];

                        items.forEach(item => {
                            const price = purchasePrices[item.product_id]?.net_unit_cost || 0;
                            const qty = parseFloat(item.qty) || 0;
                            const totalLoss = qty * price;

                            const productName = item.product?.name || '-';

                            const row = '<tr>' +
                                '<td>' + sl + '</td>' +
                                '<td>' + (damage.date || 'N/A') + '</td>' +
                                '<td>' + productName + '</td>' +
                                '<td>' + qty + '</td>' +
                                '<td>TK ' + parseFloat(price).toFixed(2) + '</td>' +
                                '<td>TK ' + totalLoss.toFixed(2) + '</td>' +
                                '<td>' + (damage.note || damage.notes || '-') + '</td>' +
                                '</tr>';
                            tbody.insertAdjacentHTML('beforeend', row);
                            sl++;
                        });
                    });
                }
            });
        </script>
    @endpush
    <div class="page-content m-2">
        <div class="container">
        </div>

        <div class="card pt-3">
            <div class="container-fluid">
                <form id="damageFilterForm" action="javascript:void(0);">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="from_date" class="form-label">From Date</label><br />
                            <input type="date" name="from_date" class="form-control" id="from_date">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="to_date" class="form-label">To Date</label><br />
                            <input type="date" name="to_date" class="form-control" id="to_date">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_semester" class="form-label">Semester</label>
                            <select id="filter_semester" name="semester_id" class="form-control large-select select2"
                                data-placeholder="Semester">
                                <option value="" selected disabled>Semester</option>
                                @forelse($semesters as $key => $value)
                                    <option value="{{ $value->id }}"> {{ $value->code }} : {{ $value->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_product" class="form-label">Product</label>
                            <select id="filter_product" name="product_id" class="form-control large-select select2"
                                data-placeholder="Product">
                                <option value="" selected disabled>Product</option>
                                @forelse($products as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mt-3 mb-3">
                            <button type="submit" class="btn btn-primary">Filter Damage Product</button>
                            <button type="button" class="btn btn-success ms-2" onclick="printTable()">Print</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div class="text-center mb-4 print-header">
                    <img src="{{ asset('backend/assets/images/bubt.png') }}" alt="BUBT Logo"
                        style="width: 80px; height: auto; margin-bottom: 10px;">
                    <h2 class="mb-1">Damage Product Report</h2>
                    <p class="mb-0">Date: {{ date('Y-m-d') }}</p>
                </div>

                <div class="table-responsive">
                    <table id="damageTable" class="table table-striped table-bordered dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Loss</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $sl = 1; @endphp
                            @foreach ($damageProducts as $damage)
                                @foreach ($damage->damageProductItem as $item)
                                    <tr>
                                        <td>{{ $sl }}</td>
                                        <td>{{ \Carbon\Carbon::parse($damage->date)->format('Y-m-d') }}</td>
                                        <td>{{ $item->product->name ?? '-' }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>TK {{ number_format($latestPrices[$item->product_id]->net_unit_cost ?? 0, 2) }}
                                        </td>
                                        <td>TK
                                            {{ number_format($item->qty * ($latestPrices[$item->product_id]->net_unit_cost ?? 0), 2) }}
                                        </td>
                                        <td>{{ $damage->note ?? '-' }}</td>
                                    </tr>
                                    @php $sl++; @endphp
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                    @php
                        $totalItems = $damageProducts->reduce(function ($carry, $damage) {
                            return $carry + $damage->damageProductItem->count();
                        }, 0);
                        $totalQty = $damageProducts->reduce(function ($carry, $damage) {
                            return $carry + ($damage->damageProductItem->sum('qty') ?? 0);
                        }, 0);
                        $grandTotal = $damageProducts->reduce(function ($carry, $damage) use ($latestPrices) {
                            $items = $damage->damageProductItem;
                            $total = 0;
                            foreach ($items as $item) {
                                $price = $latestPrices[$item->product_id]->net_unit_cost ?? 0;
                                $total += $item->qty * $price;
                            }
                            return $carry + $total;
                        }, 0);
                    @endphp

                    <div class="mt-3" style="text-align: right;">
                        <table style="width: 250px; margin-left: auto;" class="table table-bordered" id="summaryTable">
                            <tbody id="printSummaryBody">
                                <tr>
                                    <td><strong>Total Items</strong></td>
                                    <td class="text-end" id="totalItemsDisplay">{{ $totalItems }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Qty</strong></td>
                                    <td class="text-end" id="totalQtyDisplay">{{ $totalQty }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Loss</strong></td>
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
        .large-select {
            background-color: #343a40;
            color: white;
            border: 1px solid #495057;
            padding: 5px 10px;
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M7 10l5 5 5-5H7z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }

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
