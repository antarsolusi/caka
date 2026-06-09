@extends('layouts.app')

@section('title', 'Invoice - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card mb-3">
            <div class="card-body d-flex align-items-center justify-content-between">
                <h6 class="mb-0">Daftar Invoice</h6>
                <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Buat Invoice
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($invoices->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>No. Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $invoice->total_days }} hari</td>
                                        <td>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($invoice->status === 'paid')
                                                <span class="badge bg-success">Lunas</span>
                                            @else
                                                <span class="badge bg-warning">Belum Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 flex-wrap">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-file-earmark-pdf"></i>
                                                </a>
                                                @if ($invoice->status === 'unpaid')
                                                    <form action="{{ route('invoices.status', $invoice) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="paid">
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Tandai invoice ini sebagai Lunas?')">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('invoices.status', $invoice) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="status" value="unpaid">
                                                        <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('Ubah status menjadi Belum Lunas?')">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $invoices->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2 mb-0">Belum ada invoice</p>
                        <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary mt-2">Buat Invoice</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
