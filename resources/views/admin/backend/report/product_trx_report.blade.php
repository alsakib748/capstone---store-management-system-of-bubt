@extends('admin.admin_master')
@section('admin')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('purchaseFilterForm');
                const tbody = document.querySelector('#example tbody');
                const endpoint = "{{ route('filter-purchases') }}";
                var purchases = {!! json_encode($purchases->toArray()) !!};
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
                    subcategory_id: '',
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
                    currentFilters.subcategory_id = formData.get('subcategory_id') || '';
                    currentFilters.product_id = formData.get('product_id') || '';
                    fetchFilteredData();
                });

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
                    if (currentFilters.subcategory_id) {
                        var subcatText = document.querySelector('#filter_subcategory option[value="' +
                            currentFilters.subcategory_id + '"]');
                        if (subcatText) filterParts.push('Subcategory: ' + subcatText.textContent.trim());
                    }
                    if (currentFilters.product_id) {
                        var prodText = document.querySelector('#filter_product option[value="' + currentFilters
                            .product_id + '"]');
                        if (prodText) filterParts.push('Product: ' + prodText.textContent.trim());
                    }

                    var filterSummary = filterParts.length > 0 ? filterParts.join(' | ') : 'All Records';

                    // Build table HTML from current `purchases` data (ensures filtered results are used)
                    var tableHTML = '<table style="width:100%; border-collapse: collapse;">';
                    tableHTML += '<thead><tr>' +
                        '<th>SL</th>' +
                        '<th>Date</th>' +
                        '<th>Tracking No</th>' +
                        '<th>Note No</th>' +
                        '<th>Semester</th>' +
                        '<th>Department</th>' +
                        '<th>Quantity</th>' +
                        '<th>Unit Price</th>' +
                        '<th>Status</th>' +
                        '<th>Grand Total</th>' +
                        '</tr></thead><tbody>';

                    var totalItems = purchases.length || 0;
                    var totalQty = 0;
                    var grandPrice = 0;

                    for (var i = 0; i < (purchases.length || 0); i++) {
                        var p = purchases[i];
                        var items = p.purchase_items || p.purchaseItems || [];
                        var qty = 0;
                        var sumUnit = 0;
                        for (var j = 0; j < items.length; j++) {
                            qty += parseFloat(items[j].quantity) || 0;
                            sumUnit += parseFloat(items[j].net_unit_cost) || 0;
                        }
                        var avgUnit = items.length ? (sumUnit / items.length) : 0;

                        tableHTML += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + (p.date || 'N/A') + '</td>' +
                            '<td>' + (p.tracking_no || '-') + '</td>' +
                            '<td>' + (p.note_no || '-') + '</td>' +
                            '<td>' + ((p.semester && ((p.semester.code ? p.semester.code + " : " : "") + (p.semester
                                .name || ""))) || '-') + '</td>' +
                            '<td>' + (p.department ? p.department.name : '-') + '</td>' +
                            '<td>' + qty + '</td>' +
                            '<td>' + avgUnit.toFixed(2) + '</td>' +
                            '<td>' + (p.status || 'N/A') + '</td>' +
                            '<td>' + (p.grand_total ? parseFloat(p.grand_total).toFixed(2) : '0.00') + '</td>' +
                            '</tr>';

                        totalQty += qty;
                        grandPrice += parseFloat(p.grand_total) || 0;
                    }

                    tableHTML += '</tbody></table>';

                    var printWindow = window.open('', '', 'height=800,width=1000');
                    printWindow.document.write('<html><head><title>Purchase Report</title>');
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
                    printWindow.document.write('<h2 class="mb-1">Purchase Report</h2>');
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
                        grandPrice.toFixed(2) + '</td></tr>');
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
                            updateTable(data.purchases || []);
                        })
                        .catch(error => console.error('Error fetching data:', error));
                }

                function updateTable(data) {
                    purchases = data;
                    tbody.innerHTML = '';
                    let sl = 1;

                    if (!purchases.length) {
                        tbody.innerHTML =
                            '<tr><td colspan="11" class="text-center">No purchase data found for selected filters.</td></tr>';
                        return;
                    }

                    purchases.forEach(purchase => {
                        const items = purchase.purchase_items || [];
                        const totalQty = items.reduce(function(sum, item) {
                            return sum + (parseFloat(item.quantity) || 0);
                        }, 0);
                        const avgUnitPrice = items.length ? (items.reduce(function(sum, item) {
                            return sum + (parseFloat(item.net_unit_cost) || 0);
                        }, 0) / items.length) : 0;

                        const semesterText = purchase.semester ? (purchase.semester.code ? purchase.semester
                            .code + ' : ' : '') + (purchase.semester.name || '') : '-';

                        const row = '<tr>' +
                            '<td>' + sl + '</td>' +
                            '<td>' + (purchase.date || 'N/A') + '</td>' +
                            '<td>' + (purchase.tracking_no || '-') + '</td>' +
                            '<td>' + (purchase.note_no || '-') + '</td>' +
                            '<td>' + semesterText + '</td>' +
                            '<td>' + (purchase.department ? purchase.department.name : '-') + '</td>' +
                            '<td>' + totalQty + '</td>' +
                            '<td>' + avgUnitPrice.toFixed(2) + '</td>' +
                            '<td>' + (purchase.status || 'N/A') + '</td>' +
                            '<td>' + (purchase.grand_total ? parseFloat(purchase.grand_total).toFixed(2) :
                                '0.00') + '</td>' +
                            '<td>' +
                            '<div class="d-flex flex-wrap gap-1">' +
                            '<a title="Details" href="/details/purchase/' + purchase.id +
                            '" class="btn btn-info btn-sm">' +
                            '<span class="mdi mdi-eye-circle mdi-18px"></span>' +
                            '</a>' +
                            '<a title="PDF Invoice" href="/invoice/purchase/' + purchase.id +
                            '" class="btn btn-primary btn-sm">' +
                            '<span class="mdi mdi-download-circle mdi-18px"></span>' +
                            '</a>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';
                        tbody.insertAdjacentHTML('beforeend', row);
                        sl++;
                    });
                }
            });
        </script>
    @endpush
    <div class="page-content m-2">
        <div class="container">
            {{-- @include('admin.backend.report.body.report_top') --}}
        </div>
        {{-- /// end Container  --}}

        <div class="card pt-3">

            {{-- <nav class="navbar navbar-expand-lg bg-dark"> --}}
            <div class="container-fluid">

                <form id="purchaseFilterForm" action="javascript:void(0);">

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
                            <button type="submit" class="btn btn-primary">Product TRX Report</button>
                            <button type="button" class="btn btn-success ms-2" onclick="printTable()">Print</button>
                        </div>

                    </div>

                </form>

            </div>
            {{-- </nav> --}}

        </div>
        {{-- /// End Card --}}

    </div>

    <style>
        /* Ensure the navbar container is a positioning context */
        .navbar .container-fluid {
            position: relative;
        }

        /* Style the filter container */
        .filter-container {
            position: relative;
            display: inline-block;
            width: 200px;
            /* Adjust width to fit the select */
            margin-left: 10px;
        }

        /* Style the select element */
        .large-select {
            background-color: #343a40;
            /* Match navbar background */
            color: white;
            border: 1px solid #495057;
            padding: 5px 10px;
            width: 100%;
            appearance: none;
            /* Remove default dropdown arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M7 10l5 5 5-5H7z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }

        /* Style the filter icon */
        .mdi-filter-menu {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            pointer-events: none;
            /* Prevent icon from interfering with select */
        }

        /* Style the custom dropdown */
        .custom-dropdown {
            display: none;
            /* Initially hidden */
            position: absolute;
            top: 100%;
            /* Position below the select */
            right: 0;
            /* Align to the right of the filter container */
            width: 250px;
            /* Fixed width for consistency */
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            /* Ensure it appears above other elements */
        }

        /* Ensure the dropdown fits within the navbar on smaller screens */
        @media (max-width: 991px) {
            .filter-container {
                width: 100%;
                margin-top: 10px;
            }

            .custom-dropdown {
                right: auto;
                left: 0;
                width: 100%;
            }
        }

        /* Print styles - hide action column */
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
