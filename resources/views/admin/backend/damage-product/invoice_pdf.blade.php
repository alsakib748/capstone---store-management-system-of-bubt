<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Damage Product Invoice</title>
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
            color: #dc3545;
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
            <h5 style="margin-top: 10px;">Damage Product Invoice</h5>
        </div>

        <table class="info-section">
            <tr>
                <td class="info-box">
                    <h5>Damage Product Info</h5>
                    <p><strong>Date:</strong> {{ $damageProduct->date }} </p>
                    <p><strong>Tracking No:</strong> {{ $damageProduct->tracking_no ?: '-' }} </p>
                    <p><strong>Note No:</strong> {{ $damageProduct->note_no ?: '-' }} </p>
                    <p><strong>Semester:</strong> {{ $damageProduct->semester ? (($damageProduct->semester->code ? $damageProduct->semester->code . ' : ' : '') . $damageProduct->semester->name) : '-' }} </p>
                </td>
                <td class="info-box">
                    <h5>Note</h5>
                    <p>{{ $damageProduct->note ?? $damageProduct->notes ?? 'No notes' }} </p>
                </td>
            </tr>
        </table>

        <h5 style="font-weight: bold; margin: 20px 0 10px;">Damaged Items</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($damageProduct->damageProductItem as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->product->code }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity ?? $item->qty }}</td>
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
                    <p style="font-weight: bold; margin: 0;">Store Keeper Signature</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
