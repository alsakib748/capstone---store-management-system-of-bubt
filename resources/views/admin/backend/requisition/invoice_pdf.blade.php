<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Requisition Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            margin: 20mm;
            background: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            page-break-inside: avoid;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header img {
            max-width: 150px;
        }
        .invoice-header h2 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .info-section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-section td {
            width: 50%;
            padding: 15px;
            vertical-align: top;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            margin: 0 5px;
        }
        .info-box h5 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #0d6efd;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 12px;
        }
        .info-box p strong {
            color: #555;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        .table th {
            background: #e9ecef;
            font-weight: bold;
            color: #333;
        }
        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        @page {
            margin: 20mm;
        }
        @media print {
            .invoice-container {
                border: none;
                padding: 0;
            }
            .info-section td {
                background: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <img src="{{ public_path('backend/assets/images/bubt.png') }}" alt="BUBT Logo">
            <h5 style="margin-top: 10px;">Requisition Invoice</h5>
        </div>

        <table class="info-section">
            <tr>
                <td class="info-box">
                    <h5>User Info</h5>
                    <p><strong>Name:</strong> {{ $requisition->user->name ?? '-' }} </p>
                    <p><strong>Email:</strong> {{ $requisition->user->email ?? '-' }}</p>
                </td>
                <td class="info-box">
                    <h5>Requisition Info</h5>
                    <p><strong>Date:</strong> {{ $requisition->date }} </p>
                    <p><strong>Semester:</strong> {{ $requisition->semester ? (($requisition->semester->code ? $requisition->semester->code . ' : ' : '') . $requisition->semester->name) : '-' }} </p>
                    <p><strong>Notes:</strong> {{ $requisition->notes ?? '-' }} </p>
                </td>
            </tr>
        </table>

        <h5 style="font-weight: bold; margin: 20px 0 10px;">Requisition Items</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Product Code</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisition->requisitionItems as $key => $item )
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->product->code }}</td>
                        <td>{{ $item->qty }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="signature-section" style="margin-top: 50px; width: 100%; display: table; border-collapse: collapse;">
            <div style="display: table-row;">
                <div style="display: table-cell; width: 50%; text-align: left; padding-top: 50px;">
                    <div style="border-top: 1px solid #333; width: 200px; margin-bottom: 5px;"></div>
                    <p style="font-weight: bold; margin: 0;">Supervisor Signature</p>
                </div>
                <div style="display: table-cell; width: 50%; text-align: right; padding-top: 50px;">
                    <div style="border-top: 1px solid #333; width: 200px; margin-bottom: 5px; margin-left: auto;"></div>
                    <p style="font-weight: bold; margin: 0;">Get Entry Signature</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>