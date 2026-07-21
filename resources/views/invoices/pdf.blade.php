<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #0134d4;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #0134d4;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section table {
            width: 100%;
        }
        .info-section td {
            padding: 4px 0;
        }
        .info-section .label {
            color: #666;
            width: 150px;
        }
        .info-section .value {
            font-weight: bold;
        }
        .summary {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary h3 {
            margin: 0 0 10px;
            color: #0134d4;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th,
        table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.data-table th {
            background: #0134d4;
            color: white;
        }
        table.data-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .total-row {
            background: #e9ecef !important;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .badge-paid {
            background: #28a745;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }
        .badge-unpaid {
            background: #ffc107;
            color: #333;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>{{ $invoice->invoice_number }}</p>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td class="label">Nama</td>
                <td class="value">{{ $invoice->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>{{ $invoice->user->email }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Invoice</td>
                <td>{{ $invoice->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td>
                    @if ($invoice->status === 'paid')
                        <span class="badge-paid">Lunas</span>
                    @else
                        <span class="badge-unpaid">Belum Lunas</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="summary">
        <h3>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</h3>
        <p>Total {{ $invoice->total_days }} hari kehadiran x Rp 100.000</p>
    </div>

    <h3>Detail Kehadiran</h3>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Photo In</th>
                <th>Photo Out</th>
                <th>Lokasi In</th>
                <th>Lokasi Out</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->attendances as $index => $attendance)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $attendance->date->format('d/m/Y') }}</td>
                    <td>{{ $attendance->check_in_at->format('H:i') }}</td>
                    <td>{{ $attendance->check_out_at->format('H:i') }}</td>
                    <td>
                        @if ($attendance->check_in_photo)
                        <a href="{{ asset('storage/' . $attendance->check_in_photo) }}" target="_blank">
                            <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" alt="Photo In">
                        </a>
                       @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if ($attendance->check_out_photo)
                        <a href="{{ asset('storage/' . $attendance->check_out_photo) }}" target="_blank">
                            <img src="{{ asset('storage/' . $attendance->check_out_photo) }}" alt="Photo Out">
                        </a>
                       @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>@if($attendance->check_in_latitude && $attendance->check_in_longitude)
                        <a href="https://maps.google.com/?q={{ $attendance->check_in_latitude }},{{ $attendance->check_in_longitude }}" target="_blank">Longlat In
                        </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>@if($attendance->check_out_latitude && $attendance->check_out_longitude)
                        <a href="https://maps.google.com/?q={{ $attendance->check_out_latitude }},{{ $attendance->check_out_longitude }}" target="_blank">Longlat Out
                        </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>Rp 100.000</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="8" style="text-align: right;">Total</td>
                <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak oleh Aplikasi Presensi pada {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>
