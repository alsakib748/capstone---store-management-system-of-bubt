@extends('admin.admin_master')
@section('admin')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('lifetimeReportForm');
                const reportSection = document.getElementById('reportSection');
                const filterBtn = document.getElementById('filterBtn');
                const resetBtn = document.getElementById('resetBtn');

                // Set default dates (first day of current month to today)
                const today = new Date().toISOString().split('T')[0];
                const firstDayOfMonth = new Date(new Date().getFullYear(), new Date().getMonth(), 1).toISOString()
                    .split('T')[0];

                const fromDateInput = document.getElementById('from_date');
                const toDateInput = document.getElementById('to_date');

                if (fromDateInput && !fromDateInput.value) {
                    fromDateInput.value = firstDayOfMonth;
                }
                if (toDateInput && !toDateInput.value) {
                    toDateInput.value = today;
                }

                // Print function
                window.printLifetimeReport = function() {
                    var today = new Date().toISOString().split('T')[0];
                    var printWindow = window.open('', '', 'height=800,width=1000');

                    printWindow.document.write('<html><head><title>Product Lifetime Report</title>');
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
                        'h4 { margin: 15px 0 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }');
                    printWindow.document.write(
                        'table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }'
                    );
                    printWindow.document.write(
                        'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }');
                    printWindow.document.write('th { background-color: #f2f2f2; }');
                    printWindow.document.write(
                        '.summary-card { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 15px; }'
                    );
                    printWindow.document.write('.stock-positive { color: green; }');
                    printWindow.document.write('.stock-negative { color: red; }');
                    printWindow.document.write('@media print { .no-print { display: none !important; } }');
                    printWindow.document.write('</style>');
                    printWindow.document.write('</head><body>');

                    printWindow.document.write('<div class="text-center mb-4">');
                    printWindow.document.write(
                        '<img src="{{ asset('backend/assets/images/bubt.png') }}" alt="BUBT Logo">');
                    printWindow.document.write('<h2 class="mb-1">Product Lifetime History Report</h2>');
                    printWindow.document.write('<p class="mb-0">Date: ' + today + '</p>');
                    printWindow.document.write('</div>');

                    // Get filter values
                    var productName = document.querySelector('#filter_product option:checked').textContent ||
                        'All Products';
                    var fromDate = document.getElementById('from_date').value || 'N/A';
                    var toDate = document.getElementById('to_date').value || 'N/A';
                    var semesterSelect = document.querySelector('#filter_semester option:checked');
                    var semesterName = semesterSelect && semesterSelect.value ? semesterSelect.textContent :
                        'All Semesters';

                    printWindow.document.write('<div class="filter-info" style="margin-bottom: 20px;">');
                    printWindow.document.write('<strong>Product:</strong> ' + productName + ' | ');
                    printWindow.document.write('<strong>From:</strong> ' + fromDate + ' | ');
                    printWindow.document.write('<strong>To:</strong> ' + toDate + ' | ');
                    printWindow.document.write('<strong>Semester:</strong> ' + semesterName);
                    printWindow.document.write('</div>');

                    // Report content
                    printWindow.document.write(document.getElementById('reportContent').innerHTML);

                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    printWindow.print();
                };

                // Handle form submission via AJAX
                if (form) {
                    form.addEventListener('submit', function(e) {
                        return;
                    });
                }

                function renderReport(data) {
                    var report = data.report;
                    var reportSection = document.getElementById('reportSection');
                    var reportContent = document.getElementById('reportContent');

                    if (!report) {
                        reportContent.innerHTML = '<div class="alert alert-warning">No report data available.</div>';
                        reportSection.style.display = 'block';
                        return;
                    }

                    reportSection.style.display = 'block';

                    // Scroll to report section
                    reportSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // Check if there's any data in the report
                    var hasData = report.purchase.total_qty > 0 ||
                        report.issue.total_qty > 0 ||
                        report.damage.total_qty > 0 ||
                        report.return.total_qty > 0 ||
                        report.opening.opening_stock > 0 ||
                        report.opening.previous_purchase > 0;

                    // If no data, show message but still display product info
                    if (!hasData) {
                        html = '<div class="card mb-4">';
                        html += '<div class="card-header bg-primary text-white">';
                        html += '<h5 class="mb-0"><i class="mdi mdi-package-variant"></i> Product: ' + report.product
                            .name + '</h5>';
                        html += '</div>';
                        html += '<div class="card-body">';
                        html += '<div class="row">';
                        html += '<div class="col-md-3"><strong>Product Code:</strong> ' + (report.product
                            .product_code || 'N/A') + '</div>';
                        html += '<div class="col-md-3"><strong>Category:</strong> ' + (report.product.category ? report
                            .product.category.category_name : 'N/A') + '</div>';
                        html += '<div class="col-md-3"><strong>Subcategory:</strong> ' + (report.product.subcategory ?
                            report.product.subcategory.subcategory_name : 'N/A') + '</div>';
                        html += '<div class="col-md-3"><strong>Brand:</strong> ' + (report.product.brand ? report
                            .product.brand.name : 'N/A') + '</div>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                        html +=
                            '<div class="alert alert-warning text-center"><strong>No transaction records found for this product in the selected date range.</strong><br><small>There might be no purchases, issues, damages, or returns recorded yet.</small></div>';
                        html += '<div class="card mb-4">';
                        html += '<div class="card-header bg-info text-white">';
                        html += '<h5 class="mb-0">A. Opening Summary</h5>';
                        html += '</div>';
                        html += '<div class="card-body">';
                        html += '<table class="table table-bordered table-sm">';
                        html +=
                            '<thead><tr><th>Previous Purchase</th><th>Previous Issue</th><th>Previous Damage</th><th>Previous Return</th><th>Opening Stock</th></tr></thead>';
                        html += '<tbody><tr>';
                        html += '<td class="text-center">0.00</td>';
                        html += '<td class="text-center">0.00</td>';
                        html += '<td class="text-center">0.00</td>';
                        html += '<td class="text-center">0.00</td>';
                        html += '<td class="text-center text-success"><strong>0.00</strong></td>';
                        html += '</tr></tbody></table>';
                        html += '</div></div>';
                        html += '<div class="card mb-4">';
                        html += '<div class="card-header bg-warning">';
                        html += '<h5 class="mb-0">B. Current Period Summary</h5>';
                        html += '</div>';
                        html += '<div class="card-body text-center text-muted">';
                        html += '<p>No transactions found for the selected period.</p>';
                        html += '</div></div>';
                        html += '<div class="card mb-4">';
                        html += '<div class="card-header bg-success text-white">';
                        html += '<h5 class="mb-0">C. Final Closing Summary</h5>';
                        html += '</div>';
                        html += '<div class="card-body">';
                        html += '<table class="table table-bordered">';
                        html +=
                            '<thead><tr><th>Opening Stock</th><th>+ Purchase</th><th>- Issue</th><th>- Damage</th><th>+ Return</th><th>= Closing Stock</th><th>Avg Price</th><th>Stock Value</th></tr></thead>';
                        html += '<tbody><tr>';
                        html += '<td class="text-center"><span class="badge bg-secondary fs-6">0.00</span></td>';
                        html += '<td class="text-center text-success"><strong>+ 0.00</strong></td>';
                        html += '<td class="text-center text-danger"><strong>- 0.00</strong></td>';
                        html += '<td class="text-center text-danger"><strong>- 0.00</strong></td>';
                        html += '<td class="text-center text-success"><strong>+ 0.00</strong></td>';
                        html += '<td class="text-center"><span class="badge bg-secondary fs-6">0.00</span></td>';
                        html += '<td class="text-center">TK 0.00</td>';
                        html += '<td class="text-center"><strong>TK 0.00</strong></td>';
                        html += '</tr></tbody></table>';
                        html += '</div></div>';
                        reportContent.innerHTML = html;
                        return;
                    }

                    var opening = report.opening;

                    var opening = report.opening;
                    var purchase = report.purchase;
                    var issue = report.issue;
                    var damage = report.damage;
                    var returnData = report.return;
                    var closing = report.closing;

                    var html = '';

                    // Product Info Card
                    html += '<div class="card mb-4">';
                    html += '<div class="card-header bg-primary text-white">';
                    html += '<h5 class="mb-0"><i class="mdi mdi-package-variant"></i> Product: ' + report.product.name +
                        '</h5>';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<div class="row">';
                    html += '<div class="col-md-3"><strong>Product Code:</strong> ' + (report.product.product_code ||
                        'N/A') + '</div>';
                    html += '<div class="col-md-3"><strong>Category:</strong> ' + (report.product.category ? report
                        .product.category.category_name : 'N/A') + '</div>';
                    html += '<div class="col-md-3"><strong>Subcategory:</strong> ' + (report.product.subcategory ?
                        report.product.subcategory.subcategory_name : 'N/A') + '</div>';
                    html += '<div class="col-md-3"><strong>Brand:</strong> ' + (report.product.brand ? report.product
                        .brand.name : 'N/A') + '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    // A. Opening Summary
                    var openingDateLabel = report.filters.from_date ? 'Before ' + report.filters.from_date :
                        'All Previous Records';
                    html += '<div class="card mb-4">';
                    html += '<div class="card-header bg-info text-white">';
                    html += '<h5 class="mb-0">A. Opening Summary (' + openingDateLabel + ')</h5>';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<table class="table table-bordered table-sm">';
                    html +=
                        '<thead><tr><th>Previous Purchase</th><th>Previous Issue</th><th>Previous Damage</th><th>Previous Return</th><th>Opening Stock</th></tr></thead>';
                    html += '<tbody>';
                    html += '<tr>';
                    html += '<td class="text-success"><strong>' + opening.previous_purchase.toFixed(2) +
                        '</strong></td>';
                    html += '<td class="text-danger"><strong>' + opening.previous_issue.toFixed(2) + '</strong></td>';
                    html += '<td class="text-danger"><strong>' + opening.previous_damage.toFixed(2) + '</strong></td>';
                    html += '<td class="text-success"><strong>' + opening.previous_return.toFixed(2) + '</strong></td>';
                    var openingClass = opening.opening_stock >= 0 ? 'text-success' : 'text-danger';
                    html += '<td class="' + openingClass + '"><strong>' + opening.opening_stock.toFixed(2) +
                        '</strong></td>';
                    html += '</tr>';
                    html += '</tbody>';
                    html += '</table>';
                    html +=
                        '<p class="text-muted small mb-0"><em>Formula: Opening Stock = Previous Purchase - Previous Issue - Previous Damage + Previous Return</em></p>';
                    html += '</div>';
                    html += '</div>';

                    // B. Current Period Summary
                    var periodLabel = (report.filters.from_date && report.filters.to_date) ?
                        (report.filters.from_date + ' to ' + report.filters.to_date) :
                        (report.filters.from_date ? 'From ' + report.filters.from_date : (report.filters.to_date ?
                            'Until ' + report.filters.to_date : 'All Records'));
                    html += '<div class="card mb-4">';
                    html += '<div class="card-header bg-warning">';
                    html += '<h5 class="mb-0">B. Current Period Summary (' + periodLabel + ')</h5>';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<div class="row">';

                    // Purchase Summary
                    html += '<div class="col-md-6 mb-3">';
                    html += '<div class="card bg-light">';
                    html +=
                        '<div class="card-header bg-success text-white"><h6 class="mb-0">Purchase Summary</h6></div>';
                    html += '<div class="card-body">';
                    html += '<table class="table table-sm mb-0">';
                    html += '<tr><td><strong>Total Quantity</strong></td><td class="text-end">' + purchase.total_qty
                        .toFixed(2) + '</td></tr>';
                    html += '<tr><td><strong>Average Price</strong></td><td class="text-end">TK ' + purchase.avg_price
                        .toFixed(2) + '</td></tr>';
                    html += '<tr><td><strong>Total Value</strong></td><td class="text-end">TK ' + purchase.total_value
                        .toFixed(2) + '</td></tr>';
                    html += '</table>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    // Issue Summary
                    html += '<div class="col-md-6 mb-3">';
                    html += '<div class="card bg-light">';
                    html += '<div class="card-header bg-primary text-white"><h6 class="mb-0">Issue Summary</h6></div>';
                    html += '<div class="card-body">';
                    html += '<table class="table table-sm mb-0">';
                    html += '<tr><td><strong>Total Issue Quantity</strong></td><td class="text-end">' + issue.total_qty
                        .toFixed(2) + '</td></tr>';
                    html += '</table>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    // Damage Summary
                    html += '<div class="col-md-6 mb-3">';
                    html += '<div class="card bg-light">';
                    html += '<div class="card-header bg-danger text-white"><h6 class="mb-0">Damage Summary</h6></div>';
                    html += '<div class="card-body">';
                    html += '<table class="table table-sm mb-0">';
                    html += '<tr><td><strong>Total Damage Quantity</strong></td><td class="text-end">' + damage
                        .total_qty.toFixed(2) + '</td></tr>';
                    html += '<tr><td><strong>Damage Stock Value</strong></td><td class="text-end">TK ' + damage
                        .damage_value.toFixed(2) + '</td></tr>';
                    html += '</table>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    // Return Summary
                    html += '<div class="col-md-6 mb-3">';
                    html += '<div class="card bg-light">';
                    html += '<div class="card-header bg-info text-white"><h6 class="mb-0">Return Summary</h6></div>';
                    html += '<div class="card-body">';
                    html += '<table class="table table-sm mb-0">';
                    html += '<tr><td><strong>Total Return Quantity</strong></td><td class="text-end">' + returnData
                        .total_qty.toFixed(2) + '</td></tr>';
                    html += '</table>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    html += '</div>';
                    html += '</div>';
                    html += '</div>';

                    // C. Final Closing Summary
                    html += '<div class="card mb-4">';
                    html += '<div class="card-header bg-success text-white">';
                    html += '<h5 class="mb-0">C. Final Closing Summary</h5>';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<table class="table table-bordered">';
                    html +=
                        '<thead><tr class="table-success"><th>Opening Stock</th><th>+ Purchase</th><th>- Issue</th><th>- Damage</th><th>+ Return</th><th>= Closing Stock</th><th>Avg Price</th><th>Stock Value</th></tr></thead>';
                    html += '<tbody>';
                    html += '<tr>';
                    html += '<td class="text-center"><span class="badge bg-secondary fs-6">' + closing.opening_stock
                        .toFixed(2) + '</span></td>';
                    html += '<td class="text-center text-success"><strong>+ ' + closing.purchase_qty.toFixed(2) +
                        '</strong></td>';
                    html += '<td class="text-center text-danger"><strong>- ' + closing.issue_qty.toFixed(2) +
                        '</strong></td>';
                    html += '<td class="text-center text-danger"><strong>- ' + closing.damage_qty.toFixed(2) +
                        '</strong></td>';
                    html += '<td class="text-center text-success"><strong>+ ' + closing.return_qty.toFixed(2) +
                        '</strong></td>';

                    var closingClass = closing.closing_stock >= 0 ? 'text-success' : 'text-danger';
                    html += '<td class="text-center"><span class="badge bg-' + (closing.closing_stock >= 0 ? 'success' :
                        'danger') + ' fs-6">' + closing.closing_stock.toFixed(2) + '</span></td>';
                    html += '<td class="text-center">TK ' + closing.avg_price.toFixed(2) + '</td>';
                    html += '<td class="text-center"><strong>TK ' + closing.stock_value.toFixed(2) + '</strong></td>';
                    html += '</tr>';
                    html += '</tbody>';
                    html += '</table>';
                    html +=
                        '<p class="text-muted small mb-0"><em>Formula: Closing Stock = Opening Stock + Purchase Qty - Issue Qty - Damage Qty + Return Qty</em></p>';
                    html +=
                        '<p class="text-muted small mb-0"><em>Formula: Stock Value = Closing Stock × Average Purchase Price</em></p>';
                    html += '</div>';
                    html += '</div>';

                    // Detailed Transaction History
                    if (data.purchase_history && data.purchase_history.length > 0) {
                        html += '<div class="card mb-4">';
                        html +=
                            '<div class="card-header bg-success text-white"><h5 class="mb-0">D. Purchase History Details</h5></div>';
                        html += '<div class="card-body">';
                        html += '<table class="table table-sm table-bordered">';
                        html +=
                            '<thead><tr><th>Date</th><th>Invoice No</th><th>Supplier</th><th>Quantity</th><th>Unit Price</th><th>Total</th></tr></thead>';
                        html += '<tbody>';
                        data.purchase_history.forEach(function(item) {
                            var total = (item.quantity || 0) * (item.net_unit_cost || 0);
                            html += '<tr>';
                            html += '<td>' + (item.purchase ? item.purchase.date : 'N/A') + '</td>';
                            html += '<td>' + (item.purchase ? item.purchase.tracking_no : 'N/A') + '</td>';
                            html += '<td>' + (item.purchase && item.purchase.supplier ? item.purchase.supplier
                                .name : 'N/A') + '</td>';
                            html += '<td>' + (item.quantity || 0) + '</td>';
                            html += '<td>TK ' + (item.net_unit_cost || 0).toFixed(2) + '</td>';
                            html += '<td>TK ' + total.toFixed(2) + '</td>';
                            html += '</tr>';
                        });
                        html += '</tbody></table></div></div>';
                    }

                    if (data.issue_history && data.issue_history.length > 0) {
                        html += '<div class="card mb-4">';
                        html +=
                            '<div class="card-header bg-primary text-white"><h5 class="mb-0">E. Issue History Details</h5></div>';
                        html += '<div class="card-body">';
                        html += '<table class="table table-sm table-bordered">';
                        html +=
                            '<thead><tr><th>Date</th><th>Issue No</th><th>Department</th><th>User</th><th>Quantity</th></tr></thead>';
                        html += '<tbody>';
                        data.issue_history.forEach(function(item) {
                            html += '<tr>';
                            html += '<td>' + (item.issue ? item.issue.date : 'N/A') + '</td>';
                            html += '<td>' + (item.issue ? item.issue.tracking_no : 'N/A') + '</td>';
                            html += '<td>' + (item.issue && item.issue.department ? item.issue.department.name :
                                'N/A') + '</td>';
                            html += '<td>' + (item.issue && item.issue.user ? item.issue.user.name : 'N/A') +
                                '</td>';
                            html += '<td>' + (item.quantity || 0) + '</td>';
                            html += '</tr>';
                        });
                        html += '</tbody></table></div></div>';
                    }

                    if (data.damage_history && data.damage_history.length > 0) {
                        html += '<div class="card mb-4">';
                        html +=
                            '<div class="card-header bg-danger text-white"><h5 class="mb-0">F. Damage History Details</h5></div>';
                        html += '<div class="card-body">';
                        html += '<table class="table table-sm table-bordered">';
                        html +=
                            '<thead><tr><th>Date</th><th>Damage No</th><th>Semester</th><th>Quantity</th><th>Reason</th></tr></thead>';
                        html += '<tbody>';
                        data.damage_history.forEach(function(item) {
                            html += '<tr>';
                            html += '<td>' + (item.damage_product ? item.damage_product.date : 'N/A') + '</td>';
                            html += '<td>' + (item.damage_product ? item.damage_product.tracking_no : 'N/A') +
                                '</td>';
                            html += '<td>' + (item.damage_product && item.damage_product.semester ? item
                                .damage_product.semester.name : 'N/A') + '</td>';
                            html += '<td>' + (item.quantity || 0) + '</td>';
                            html += '<td>' + (item.damage_product ? (item.damage_product.note_no || 'N/A') :
                                'N/A') + '</td>';
                            html += '</tr>';
                        });
                        html += '</tbody></table></div></div>';
                    }

                    if (data.return_history && data.return_history.length > 0) {
                        html += '<div class="card mb-4">';
                        html +=
                            '<div class="card-header bg-info text-white"><h5 class="mb-0">G. Return History Details</h5></div>';
                        html += '<div class="card-body">';
                        html += '<table class="table table-sm table-bordered">';
                        html +=
                            '<thead><tr><th>Date</th><th>Return No</th><th>Original Issue</th><th>User</th><th>Quantity</th></tr></thead>';
                        html += '<tbody>';
                        data.return_history.forEach(function(item) {
                            html += '<tr>';
                            html += '<td>' + (item.issue_return ? item.issue_return.return_date : 'N/A') +
                                '</td>';
                            html += '<td>' + (item.issue_return ? item.issue_return.tracking_no : 'N/A') +
                                '</td>';
                            html += '<td>' + (item.issue_return && item.issue_return.issue ? item.issue_return
                                .issue.tracking_no : 'N/A') + '</td>';
                            html += '<td>' + (item.issue_return && item.issue_return.user ? item.issue_return
                                .user.name : 'N/A') + '</td>';
                            html += '<td>' + (item.quantity || 0) + '</td>';
                            html += '</tr>';
                        });
                        html += '</tbody></table></div></div>';
                    }

                    reportContent.innerHTML = html;
                }

                // Reset button
                if (resetBtn) {
                    resetBtn.addEventListener('click', function() {
                        form.reset();
                        document.getElementById('reportSection').style.display = 'none';
                        document.getElementById('reportContent').innerHTML = '';
                        if (typeof $.fn.select2 !== 'undefined') {
                            $('#filter_product').val('').trigger('change');
                            $('#filter_semester').val('').trigger('change');
                        }
                    });
                }
            });
        </script>
    @endpush

    <div class="page-content">
        <div class="container">
            <!-- Filter Card -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="mdi mdi-chart-line"></i> Product Lifetime History Report</h5>
                </div>
                <div class="card-body">
                    <form id="lifetimeReportForm" action="{{ route('product.lifetime.report.generate') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-12 mb-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" name="from_date" class="form-control" id="from_date">
                            </div>

                            <div class="col-lg-3 col-md-6 col-12 mb-3">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" name="to_date" class="form-control" id="to_date">
                            </div>

                            <div class="col-lg-3 col-md-6 col-12 mb-3">
                                <label for="filter_product" class="form-label">Product <span
                                        class="text-danger">*</span></label>
                                <select name="product_id" id="filter_product" class="form-control select2"
                                    data-placeholder="Select Product" required>
                                    <option value="" selected disabled>Select Product</option>
                                    @forelse($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}
                                            ({{ $product->product_code }})
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 col-12 mb-3">
                                <label for="filter_semester" class="form-label">Semester (Optional)</label>
                                <select name="semester_id" id="filter_semester" class="form-control select2"
                                    data-placeholder="Select Semester">
                                    <option value="" selected>All Semesters</option>
                                    @forelse($semesters as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->code }} : {{ $semester->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" id="filterBtn" class="btn btn-primary">
                                    <i class="mdi mdi-filter"></i> Filter
                                </button>
                                <button type="button" id="resetBtn" class="btn btn-secondary ms-2">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </button>
                                <button type="button" class="btn btn-success ms-2" onclick="printLifetimeReport()">
                                    <i class="mdi mdi-printer"></i> Print
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!-- End Filter Card -->

            <!-- Report Section -->
            <div id="reportSection" style="display: {{ isset($reportData) ? 'block' : 'none' }};">
                <div id="reportContent">
                    @if (isset($reportData) && $reportData)
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="mdi mdi-package-variant"></i> Product:
                                    {{ $reportData['product']->name }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3"><strong>Product Code:</strong>
                                        {{ $reportData['product']->product_code ?? 'N/A' }}</div>
                                    <div class="col-md-3"><strong>Category:</strong>
                                        {{ $reportData['product']->category->category_name ?? 'N/A' }}</div>
                                    <div class="col-md-3"><strong>Subcategory:</strong>
                                        {{ $reportData['product']->subcategory->subcategory_name ?? 'N/A' }}</div>
                                    <div class="col-md-3"><strong>Brand:</strong>
                                        {{ $reportData['product']->brand->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- A. Opening Summary -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">A. Opening Summary
                                    ({{ $reportData['filters']['from_date'] ? 'Before ' . $reportData['filters']['from_date'] : 'All Previous Records' }})
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Previous Purchase</th>
                                            <th>Previous Issue</th>
                                            <th>Previous Damage</th>
                                            <th>Previous Return</th>
                                            <th>Opening Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-success">
                                                <strong>{{ number_format($reportData['opening']['previous_purchase'], 2) }}</strong>
                                            </td>
                                            <td class="text-danger">
                                                <strong>{{ number_format($reportData['opening']['previous_issue'], 2) }}</strong>
                                            </td>
                                            <td class="text-danger">
                                                <strong>{{ number_format($reportData['opening']['previous_damage'], 2) }}</strong>
                                            </td>
                                            <td class="text-success">
                                                <strong>{{ number_format($reportData['opening']['previous_return'], 2) }}</strong>
                                            </td>
                                            <td
                                                class="{{ $reportData['opening']['opening_stock'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                <strong>{{ number_format($reportData['opening']['opening_stock'], 2) }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="text-muted small mb-0"><em>Formula: Opening Stock = Previous Purchase - Previous
                                        Issue - Previous Damage + Previous Return</em></p>
                            </div>
                        </div>

                        <!-- B. Current Period Summary -->
                        @php
                            $fromDate = $reportData['filters']['from_date'] ?? null;
                            $toDate = $reportData['filters']['to_date'] ?? null;
                            $periodLabel = '';
                            if ($fromDate && $toDate) {
                                $periodLabel = $fromDate . ' to ' . $toDate;
                            } elseif ($fromDate) {
                                $periodLabel = 'From ' . $fromDate;
                            } elseif ($toDate) {
                                $periodLabel = 'Until ' . $toDate;
                            } else {
                                $periodLabel = 'All Records';
                            }
                        @endphp
                        <div class="card mb-4">
                            <div class="card-header bg-warning">
                                <h5 class="mb-0">B. Current Period Summary ({{ $periodLabel }})</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Purchase Summary -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-header bg-success text-white">
                                                <h6 class="mb-0">Purchase Summary</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm mb-0">
                                                    <tr>
                                                        <td><strong>Total Quantity</strong></td>
                                                        <td class="text-end">
                                                            {{ number_format($reportData['purchase']['total_qty'], 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Average Price</strong></td>
                                                        <td class="text-end">TK
                                                            {{ number_format($reportData['purchase']['avg_price'], 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Total Value</strong></td>
                                                        <td class="text-end">TK
                                                            {{ number_format($reportData['purchase']['total_value'], 2) }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Issue Summary -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0">Issue Summary</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm mb-0">
                                                    <tr>
                                                        <td><strong>Total Issue Quantity</strong></td>
                                                        <td class="text-end">
                                                            {{ number_format($reportData['issue']['total_qty'], 2) }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Damage Summary -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-header bg-danger text-white">
                                                <h6 class="mb-0">Damage Summary</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm mb-0">
                                                    <tr>
                                                        <td><strong>Total Damage Quantity</strong></td>
                                                        <td class="text-end">
                                                            {{ number_format($reportData['damage']['total_qty'], 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Damage Stock Value</strong></td>
                                                        <td class="text-end">TK
                                                            {{ number_format($reportData['damage']['damage_value'], 2) }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Return Summary -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light">
                                            <div class="card-header bg-info text-white">
                                                <h6 class="mb-0">Return Summary</h6>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm mb-0">
                                                    <tr>
                                                        <td><strong>Total Return Quantity</strong></td>
                                                        <td class="text-end">
                                                            {{ number_format($reportData['return']['total_qty'], 2) }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- C. Final Closing Summary -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">C. Final Closing Summary</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="table-success">
                                            <th class="text-center">Opening Stock</th>
                                            <th class="text-center">+ Purchase</th>
                                            <th class="text-center">- Issue</th>
                                            <th class="text-center">- Damage</th>
                                            <th class="text-center">+ Return</th>
                                            <th class="text-center">= Closing Stock</th>
                                            <th class="text-center">Avg Price</th>
                                            <th class="text-center">Stock Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center"><span
                                                    class="badge bg-secondary fs-6">{{ number_format($reportData['closing']['opening_stock'], 2) }}</span>
                                            </td>
                                            <td class="text-center text-success"><strong>+
                                                    {{ number_format($reportData['closing']['purchase_qty'], 2) }}</strong>
                                            </td>
                                            <td class="text-center text-danger"><strong>-
                                                    {{ number_format($reportData['closing']['issue_qty'], 2) }}</strong>
                                            </td>
                                            <td class="text-center text-danger"><strong>-
                                                    {{ number_format($reportData['closing']['damage_qty'], 2) }}</strong>
                                            </td>
                                            <td class="text-center text-success"><strong>+
                                                    {{ number_format($reportData['closing']['return_qty'], 2) }}</strong>
                                            </td>
                                            <td class="text-center"><span
                                                    class="badge bg-{{ $reportData['closing']['closing_stock'] >= 0 ? 'success' : 'danger' }} fs-6">{{ number_format($reportData['closing']['closing_stock'], 2) }}</span>
                                            </td>
                                            <td class="text-center">TK
                                                {{ number_format($reportData['closing']['avg_price'], 2) }}</td>
                                            <td class="text-center"><strong>TK
                                                    {{ number_format($reportData['closing']['stock_value'], 2) }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="text-muted small mb-0"><em>Formula: Closing Stock = Opening Stock + Purchase Qty
                                        - Issue Qty - Damage Qty + Return Qty</em></p>
                                <p class="text-muted small mb-0"><em>Formula: Stock Value = Closing Stock × Average
                                        Purchase Price</em></p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- End Report Section -->
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .card {
                break-inside: avoid;
                margin-bottom: 20px;
            }

            .page-content {
                padding: 0;
            }

            .container {
                max-width: 100%;
                padding: 0;
            }
        }

        .table-sm td,
        .table-sm th {
            padding: 0.5rem;
        }

        .text-end {
            text-align: right;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection
