@extends('layouts.app')

@section('title', 'Detail Invoice - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card mb-3">
            <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h6 class="mb-0">Detail Invoice</h6>
                <div class="d-flex gap-2">
                    @if ($invoice->status === 'unpaid')
                        <form action="{{ route('invoices.status', $invoice) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Tandai invoice ini sebagai Lunas?')">
                                <i class="bi bi-check-lg"></i> Tandai Lunas
                            </button>
                        </form>
                    @else
                        <form action="{{ route('invoices.status', $invoice) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="unpaid">
                            <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Ubah status menjadi Belum Lunas?')">
                                <i class="bi bi-arrow-counterclockwise"></i> Batalkan Lunas
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-sm btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <small class="text-muted d-block">No. Invoice</small>
                        <strong>{{ $invoice->invoice_number }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Tanggal</small>
                        <strong>{{ $invoice->created_at->format('d/m/Y') }}</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Jumlah Hari</small>
                        <strong>{{ $invoice->total_days }} hari</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Status</small>
                        @if ($invoice->status === 'paid')
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-warning">Belum Lunas</span>
                        @endif
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block">Total Nominal</small>
                        <h4 class="text-primary mb-0">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="mb-3">Detail Kehadiran</h6>

                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
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
                                    <td>
                                        @if ($attendance->check_in_at)
                                            <span class="text-success">{{ $attendance->check_in_at->format('H:i') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attendance->check_out_at)
                                            <span class="text-danger">{{ $attendance->check_out_at->format('H:i') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attendance->check_in_photo && file_exists(public_path('storage/' . $attendance->check_in_photo)))
                                        <a href="{{ asset('storage/' . $attendance->check_in_photo) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" alt="Photo In" class="img-thumbnail" style="max-width: 50px;">
                                        </a>
                                    @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attendance->check_out_photo && file_exists(public_path('storage/' . $attendance->check_out_photo)))
                                        <a href="{{ asset('storage/' . $attendance->check_out_photo) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $attendance->check_out_photo) }}" alt="Photo Out" class="img-thumbnail" style="max-width: 50px;">
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
                            <tr class="table-primary">
                                <td colspan="7" class="text-start"><strong>Total</strong></td>
                                <td colspan="2" class="text-end"><strong>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
