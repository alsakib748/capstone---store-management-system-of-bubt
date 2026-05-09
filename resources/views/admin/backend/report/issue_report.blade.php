@extends('admin.admin_master')
@section('admin')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('issueFilterForm');
                const tbody = document.querySelector('#issueTable tbody');
                const endpoint = "{{ route('filter-issues') }}";
                var issues = {!! json_encode($issues) !!};
                var latestPrices = {!! json_encode($latestPrices->toArray()) !!};
                var usersEndpointBase = "{{ url('/get/users/by/department') }}";

                if (!form || !tbody) {
                    return;
                }

                const departmentSelect = document.getElementById('filter_department');
                const userSelect = document.getElementById('filter_user');

                // Initialize select2 manually and listen for changes
                if (typeof $.fn.select2 !== 'undefined') {
                    $(departmentSelect).select2({
                        allowClear: true,
                        placeholder: $(departmentSelect).data('placeholder') || 'Select Department',
                        width: '100%'
                    });

                    $(userSelect).select2({
                        allowClear: true,
                        placeholder: $(userSelect).data('placeholder') || 'Select User',
                        width: '100%'
                    });

                    // Listen to select2 change event
                    $(departmentSelect).on('change', function() {
                        var deptId = $(this).val();
                        console.log('Department selected:', deptId);
                        loadUsersByDepartment(deptId);
                    });
                }

                function loadUsersByDepartment(departmentId, selectedUserId) {
                    console.log('loadUsersByDepartment called with:', departmentId);
                    if (!departmentId) {
                        userSelect.innerHTML = '<option value="" selected disabled>Select User</option>';
                        if (typeof $.fn.select2 !== 'undefined') {
                            $(userSelect).trigger('change');
                        }
                        return;
                    }

                    var fetchUrl = usersEndpointBase + '/' + encodeURIComponent(departmentId);
                    console.log('Fetching from:', fetchUrl);

                    fetch(fetchUrl, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            cache: 'no-cache'
                        })
                        .then(response => response.json())
                        .then(users => {
                            console.log('Users received:', users);
                            userSelect.innerHTML = '<option value="" selected disabled>Select User</option>';
                            users.forEach(user => {
                                const option = document.createElement('option');
                                option.value = user.id;
                                option.textContent = user.name + ' (' + user.email + ')';
                                if (selectedUserId && String(user.id) === String(selectedUserId)) {
                                    option.selected = true;
                                }
                                userSelect.appendChild(option);
                            });
                            if (typeof $.fn.select2 !== 'undefined') {
                                $(userSelect).trigger('change');
                            }
                        })
                        .catch(error => {
                            console.error('Error loading users:', error);
                            userSelect.innerHTML = '<option value="" selected disabled>Select User</option>';
                            if (typeof $.fn.select2 !== 'undefined') {
                                $(userSelect).trigger('change');
                            }
                        });
                }

                // Store current filter values
                var currentFilters = {
                    from_date: '',
                    to_date: '',
                    semester_id: '',
                    department_id: '',
                    user_id: '',
                    issued_by: '',
                    product_id: ''
                };

                // Handle form submission
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Update stored filters
                    var formData = new FormData(form);
                    currentFilters.from_date = formData.get('from_date') || '';
                    currentFilters.to_date = formData.get('to_date') || '';
                    currentFilters.semester_id = formData.get('semester_id') || '';
                    currentFilters.department_id = formData.get('department_id') || '';
                    currentFilters.user_id = formData.get('user_id') || '';
                    currentFilters.issued_by = formData.get('issued_by') || '';
                    currentFilters.product_id = formData.get('product_id') || '';
                    fetchFilteredData();
                });

                // Initialize totals on page load
                updateSummaryDisplay();

                // Print function
                window.printTable = function() {
                    var today = new Date().toISOString().split('T')[0];

                    function getIssuedByName(issue) {
                        return (issue.issuedByUser && issue.issuedByUser.name) ||
                            (issue.issued_by_user && issue.issued_by_user.name) ||
                            (issue.user && issue.user.name) ||
                            '-';
                    }

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
                    if (currentFilters.department_id) {
                        var deptText = document.querySelector('#filter_department option[value="' + currentFilters
                            .department_id + '"]');
                        if (deptText) filterParts.push('Department: ' + deptText.textContent.trim());
                    }
                    if (currentFilters.user_id) {
                        var userText = document.querySelector('#filter_user option[value="' + currentFilters
                            .user_id + '"]');
                        if (userText) filterParts.push('User: ' + userText.textContent.trim());
                    }
                    if (currentFilters.issued_by) {
                        var issuedText = document.querySelector('#filter_issued_by option[value="' + currentFilters
                            .issued_by + '"]');
                        if (issuedText) filterParts.push('Issued By: ' + issuedText.textContent.trim());
                    }
                    if (currentFilters.product_id) {
                        var prodText = document.querySelector('#filter_product option[value="' + currentFilters
                            .product_id + '"]');
                        if (prodText) filterParts.push('Product: ' + prodText.textContent.trim());
                    }

                    var filterSummary = filterParts.length > 0 ? filterParts.join(' | ') : 'All Records';

                    // Build table HTML from current `issues` data (ensures filtered results are used)
                    var tableHTML = '<table style="width:100%; border-collapse: collapse;">';
                    tableHTML += '<thead><tr>' +
                        '<th>SL</th>' +
                        '<th>Date</th>' +
                        '<th>Product</th>' +
                        '<th>Issued By</th>' +
                        '<th>User</th>' +
                        '<th>Semester</th>' +
                        '<th>Department</th>' +
                        '<th>Quantity</th>' +
                        '<th>Unit Price</th>' +
                        '<th>Total Value</th>' +
                        '</tr></thead><tbody>';

                    var totalItems = 0;
                    var totalQty = 0;
                    var grandTotal = 0;

                    for (var i = 0; i < (issues.length || 0); i++) {
                        var issue = issues[i];
                        var items = issue.issue_items || issue.issueItems || [];

                        for (var j = 0; j < items.length; j++) {
                            totalItems++;
                            var item = items[j];
                            var qty = parseFloat(item.qty) || 0;
                            var productId = item.product_id || (item.product ? item.product.id : null);
                            var price = productId && latestPrices[productId] ? parseFloat(latestPrices[productId]
                                .net_unit_cost) || 0 : 0;
                            var totalValue = qty * price;

                            var productName = item.product ? item.product.name : '-';
                            var issuedByName = getIssuedByName(issue);
                            var semesterText = issue.semester ? (issue.semester.code ? issue.semester.code + ' : ' :
                                '') + (issue.semester.name || '') : '-';

                            var user = issue.user ? issue.user.name : '-';
                            var departmentName = issue.department ? issue.department.name : ((issue.user && issue
                                .user.department) ? issue.user.department.name : '-');

                            tableHTML += '<tr>' +
                                '<td>' + totalItems + '</td>' +
                                '<td>' + (issue.date || 'N/A') + '</td>' +
                                '<td>' + productName + '</td>' +
                                '<td>' + issuedByName + '</td>' +
                                '<td>' + user + '</td>' +
                                '<td>' + semesterText + '</td>' +
                                '<td>' + departmentName + '</td>' +
                                '<td>' + qty + '</td>' +
                                '<td>TK ' + price.toFixed(2) + '</td>' +
                                '<td>TK ' + totalValue.toFixed(2) + '</td>' +
                                '</tr>';

                            totalQty += qty;
                            grandTotal += totalValue;
                        }
                    }

                    tableHTML += '</tbody></table>';

                    var printWindow = window.open('', '', 'height=800,width=1000');
                    printWindow.document.write('<html><head><title>Issue Report</title>');
                    printWindow.document.write('<style>');
                    printWindow.document.write('body { font-family: Arial, sans-serif; padding: 20px; }');
                    printWindow.document.write('.text-center { text-align: center; }');
                    printWindow.document.write('.mb-4 { margin-bottom: 20px; }');
                    printWindow.document.write('.mb-1 { margin-bottom: 5px; }');
                    printWindow.document.write('.mb-0 { margin-bottom: 0; }');
                    printWindow.document.write(
                        '.filter-info { margin-top: 10px; font-size: 14px; color: #555; }');
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
                    printWindow.document.write('<h2 class="mb-1">Issue Report</h2>');
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
                            updateTable(data.issues || []);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function updateTable(data) {
                    issues = data || [];
                    tbody.innerHTML = '';
                    let sl = 1;

                    function getIssuedByName(issue) {
                        return (issue.issuedByUser && issue.issuedByUser.name) ||
                            (issue.issued_by_user && issue.issued_by_user.name) ||
                            (issue.user && issue.user.name) ||
                            '-';
                    }

                    if (!issues.length) {
                        tbody.innerHTML =
                            '<tr><td colspan="10" class="text-center">No issue data found for selected filters.</td></tr>';
                        return;
                    }

                    issues.forEach(issue => {
                        const items = issue.issue_items || issue.issueItems || [];

                        items.forEach(item => {
                            const qty = parseFloat(item.qty) || 0;
                            const productId = item.product_id || (item.product ? item.product
                                .id :
                                null);
                            const price = productId && latestPrices[productId] ? parseFloat(
                                latestPrices[productId].net_unit_cost) || 0 : 0;
                            const totalValue = qty * price;
                            const productName = item.product ? item.product.name : '-';
                            const issuedByName = getIssuedByName(issue);
                            const semesterText = issue.semester ? (issue.semester.code ? issue
                                .semester
                                .code + ' : ' : '') + (issue.semester.name || '') : '-';

                            const row = '<tr>' +
                                '<td>' + sl + '</td>' +
                                '<td>' + (issue.date || 'N/A') + '</td>' +
                                '<td>' + productName + '</td>' +
                                '<td>' + issuedByName + '</td>' +
                                '<td>' + (issue.user ? issue.user.name : '-') + '</td>' +
                                '<td>' + semesterText + '</td>' +
                                '<td>' + (issue.department ? issue.department.name : ((issue.user &&
                                    issue.user.department) ? issue.user.department.name : '-')) +
                                '</td>' +
                                '<td>' + qty + '</td>' +
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

                    for (var i = 0; i < (issues.length || 0); i++) {
                        var issue = issues[i];
                        var items = issue.issue_items || issue.issueItems || [];
                        for (var j = 0; j < items.length; j++) {
                            totalItems++;
                            var qty = parseFloat(items[j].qty) || 0;
                            var productId = items[j].product_id || (items[j].product ? items[j].product.id :
                                null);
                            var price = productId && latestPrices[productId] ? parseFloat(latestPrices[
                                    productId]
                                .net_unit_cost) || 0 : 0;
                            totalQty += qty;
                            grandTotal += qty * price;
                        }
                    }

                    var totalItemsDisplay = document.getElementById('totalItemsDisplay');
                    var totalQtyDisplay = document.getElementById('totalQtyDisplay');
                    var grandTotalDisplay = document.getElementById('grandTotalDisplay');

                    if (totalItemsDisplay) {
                        totalItemsDisplay.textContent = totalItems;
                    }
                    if (totalQtyDisplay) {
                        totalQtyDisplay.textContent = totalQty;
                    }
                    if (grandTotalDisplay) {
                        grandTotalDisplay.textContent = 'TK ' + grandTotal.toFixed(2);
                    }
                }
            });
        </script>
    @endpush
    <div class="page-content m-2">
        <div class="container">
        </div>

        <div class="card pt-3">
            <div class="container-fluid">

                <form id="issueFilterForm" action="javascript:void(0);">

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
                            <label for="filter_department" class="form-label">Department</label>
                            <select id="filter_department" name="department_id" class="form-control large-select select2"
                                data-placeholder="Department">
                                <option value="" selected disabled>Department</option>
                                @forelse($departments as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->name }} - {{ $value->code }} </option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_user" class="form-label">User</label>
                            <select id="filter_user" name="user_id" class="form-control large-select select2"
                                data-placeholder="User">
                                <option value="" selected disabled>Select User</option>
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="filter_issued_by" class="form-label">Issued By</label>
                            <select id="filter_issued_by" name="issued_by" class="form-control large-select select2"
                                data-placeholder="Issued By">
                                <option value="" selected disabled>Issued By</option>
                                @forelse($users as $key => $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                            <button type="submit" class="btn btn-primary">Filter Issues</button>
                            <button type="button" class="btn btn-success ms-2" onclick="printTable()">Print</button>
                        </div>

                    </div>

                </form>

            </div>

            <div class="card-body">
                <!-- Report Header -->
                <div class="text-center mb-4 print-header">
                    <img src="{{ asset('backend/assets/images/bubt.png') }}" alt="BUBT Logo"
                        style="width: 80px; height: auto; margin-bottom: 10px;">
                    <h2 class="mb-1">Issue Report</h2>
                    <p class="mb-0">Date: {{ date('Y-m-d') }}</p>
                </div>

                <div class="table-responsive">
                    <table id="issueTable" class="table table-striped table-bordered dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Issued By</th>
                                <th>User</th>
                                <th>Semester</th>
                                <th>Department</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($issues as $key => $issue)
                                @foreach ($issue->issueItems as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($issue->date)->format('Y-m-d') }}</td>
                                        <td>{{ $item->product->name ?? '-' }}</td>
                                        <td>{{ $issue->issuedByUser?->name ?? '-' }}</td>
                                        <td>{{ $issue->user?->name ?? '-' }}</td>
                                        <td>{{ $issue->semester ? ($issue->semester->code ? $issue->semester->code . ' : ' : '') . $issue->semester->name : '-' }}
                                        </td>
                                        <td>{{ $issue->department?->name ?? ($issue->user?->department?->name ?? '-') }}
                                        </td>
                                        <td>{{ $item->qty }}</td>
                                        <td>TK {{ number_format($latestPrices[$item->product_id]->net_unit_cost ?? 0, 2) }}
                                        </td>
                                        <td>TK
                                            {{ number_format($item->qty * ($latestPrices[$item->product_id]->net_unit_cost ?? 0) ?? 0, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                    @php
                        $totalItems = collect($issues)->reduce(function ($carry, $issue) {
                            return $carry + ($issue->issueItems ? $issue->issueItems->count() : 0);
                        }, 0);
                        $totalQty = collect($issues)->reduce(function ($carry, $issue) {
                            return $carry + ($issue->issueItems ? $issue->issueItems->sum('qty') : 0);
                        }, 0);
                        $grandTotal = collect($issues)->reduce(function ($carry, $issue) use ($latestPrices) {
                            $total = 0;
                            if ($issue->issueItems) {
                                foreach ($issue->issueItems as $item) {
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
        .large-select {
            background-color: #343a40;
            color: white;
            border: 1px solid #495057;
            padding: 5px 10px;
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
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
