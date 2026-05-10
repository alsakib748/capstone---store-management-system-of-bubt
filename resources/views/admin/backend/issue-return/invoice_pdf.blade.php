<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Return Invoice - {{ $issueReturn->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #333;
            margin: 10mm;
            background: #fff;
        }
        .invoice-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
            page-break-inside: avoid;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #0066cc;
        }
        .invoice-header img {
            max-width: 60px;
            vertical-align: middle;
        }
        .invoice-header h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0 0;
            display: inline-block;
            vertical-align: middle;
            margin-left: 10px;
        }
        .info-section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-section td {
            width: 50%;
            padding: 6px 10px;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }
        .info-section .label {
            font-weight: bold;
            color: #495057;
            width: 100px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #dee2e6;
            padding: 6px 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 10px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .notes-section {
            margin-bottom: 15px;
            padding: 8px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            font-size: 10px;
        }
        .notes-section strong {
            display: block;
            margin-bottom: 3px;
        }
        .signature-section {
            margin-top: 25px;
            width: 100%;
            display: table;
            border-collapse: collapse;
        }
        .signature-section > div {
            display: table-row;
        }
        .signature-section > div > div {
            display: table-cell;
            width: 50%;
            padding-top: 25px;
        }
        .signature-section > div > div:first-child {
            text-align: left;
        }
        .signature-section > div > div:last-child {
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 150px;
            margin-bottom: 3px;
        }
        .signature-section > div > div:last-child .signature-line {
            margin-left: auto;
        }
        .signature-section p {
            font-weight: bold;
            margin: 0;
            font-size: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            color: #6c757d;
            font-size: 9px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <img src="{{ public_path('backend/assets/images/bubt.png') }}" alt="BUBT Logo">
            <h2>Issue Return Invoice</h2>
        </div>

        <table class="info-section">
            <tr>
                <td>
                    <span class="label">Return Date:</span>
                    {{ \Carbon\Carbon::parse($issueReturn->return_date)->format('Y-m-d') }}
                </td>
                <td>
                    <span class="label">Return ID:</span>
                    {{ $issueReturn->id }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">User:</span>
                    {{ $issueReturn->user->name ?? '-' }}
                </td>
                <td>
                    <span class="label">Email:</span>
                    {{ $issueReturn->user->email ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">Original Issue:</span>
                    {{ $issueReturn->issue->tracking_no ?? '-' }}
                </td>
                <td>
                    <span class="label">Issue Date:</span>
                    {{ $issueReturn->issue ? \Carbon\Carbon::parse($issueReturn->issue->date)->format('Y-m-d') : '-' }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">Created By:</span>
                    {{ $issueReturn->createdBy->name ?? '-' }}
                </td>
                <td></td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 40px;">SL</th>
                    <th>Product</th>
                    <th style="width: 80px;">Code</th>
                    <th class="text-center" style="width: 60px;">Qty</th>
                    <th class="text-center" style="width: 80px;">Condition</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($issueReturn->issueReturnItems as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->product->name ?? '-' }}</td>
                        <td>{{ $item->product->code ?? '-' }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-center">{{ $item->condition == 'good' ? 'Good' : 'Damaged' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($issueReturn->notes)
            <div class="notes-section">
                <strong>Notes:</strong>
                {{ $issueReturn->notes }}
            </div>
        @endif

        <div class="signature-section">
            <div>
                <div>
                    <div class="signature-line"></div>
                    <p>Supervisor Signature</p>
                </div>
                <div>
                    <div class="signature-line"></div>
                    <p>Store Keeper Signature</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Generated on {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>

</html>