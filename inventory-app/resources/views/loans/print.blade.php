<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset_Loan_Report_Telkomsel_{{ date('Ymd_His') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #666;
        }
        .meta {
            width: 100%;
            margin-bottom: 20px;
            font-size: 11px;
        }
        .meta td {
            padding: 2px 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .status-badge {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
            text-align: right;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            width: 200px;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            padding-top: 5px;
            font-weight: bold;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div class="no-print" style="background: #fdf6e2; border: 1px solid #f5e7c6; padding: 10px; margin-bottom: 20px; border-radius: 6px; text-align: center;">
        <p style="margin: 0; font-size: 13px;">
            This page is configured for printing. The printer dialog will open automatically.
            Otherwise, please press <strong>Ctrl + P</strong> (Windows) or <strong>Cmd + P</strong> (Mac).
            <button onclick="window.print()" style="margin-left: 10px; background: rgba(178, 86, 159, 1); color: white; border: none; padding: 5px 10px; border-radius: 4px; font-weight: bold; cursor: pointer;">Print Now</button>
        </p>
    </div>

    <div class="header">
        <h1>Office Asset Loan Report</h1>
        <p>PT Telkomsel Indonesia - Warehouse Asset Inventory Management App (InLife)</p>
    </div>

    <table class="meta">
        <tr>
            <td style="width: 15%"><strong>Print Date</strong></td>
            <td style="width: 2%">:</td>
            <td>{{ date('d F Y H:i:s') }}</td>
            <td style="width: 15%"><strong>Printed By</strong></td>
            <td style="width: 2%">:</td>
            <td>{{ Auth::user()->name }} ({{ Auth::user()->role }})</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Borrow Date</th>
                <th style="width: 20%">Borrower Name</th>
                <th style="width: 30%">Items List & Qty</th>
                <th style="width: 15%">Return Date</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $index => $loan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $loan->borrow_date->format('d M Y') }}</td>
                    <td><strong>{{ $loan->borrower_name }}</strong></td>
                    <td>
                        @foreach($loan->details as $detail)
                            • {{ $detail->product->name ?? 'Deleted Item' }} ({{ $detail->qty }} Units)<br>
                        @endforeach
                    </td>
                    <td>
                        {{ $loan->return_date ? $loan->return_date->format('d M Y') : 'Not Returned' }}
                    </td>
                    <td>
                        <span class="status-badge">{{ $loan->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No loan transactions recorded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Jakarta, {{ date('d F Y') }}</p>
            <p>Authorized By,</p>
            <div class="signature-line">
                {{ Auth::user()->name }}<br>
                <span style="font-weight: normal; font-size: 10px; text-transform: uppercase;">{{ Auth::user()->role }}</span>
            </div>
        </div>
    </div>

    <script>
        // Otomatis membuka dialog print saat halaman dimuat
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
