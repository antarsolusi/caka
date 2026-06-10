@extends('layouts.app')

@section('title', 'Invoice - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card mb-2">
            <div class="card-body d-flex align-items-center justify-content-between">
                <h6 class="mb-0">Daftar Invoice</h6>
                <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Buat Invoice
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($invoices->count() > 0)
            @foreach ($invoices as $invoice)
                <div class="card timeline-card mb-2 {{ $invoice->status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="timeline-text mb-1">
                                <span class="badge bg-dark mb-1 rounded-pill" style="font-size: 10px;">{{ $invoice->created_at->format('d M Y') }}</span>
                                <h6 class="mb-0" style="font-size: 14px;">{{ $invoice->invoice_number }}</h6>
                            </div>
                            <div class="timeline-icon mb-1">
                                <i class="bi bi-receipt h4 mb-0 {{ $invoice->status === 'paid' ? 'text-white' : 'text-dark' }}"></i>
                            </div>
                        </div>

                        <div class="row g-1 mb-1">
                            <div class="col-6">
                                <small class="{{ $invoice->status === 'paid' ? 'text-grey-900' : 'text-muted' }} d-block" style="font-size: 11px;">Total Hari</small>
                                <strong class="{{ $invoice->status === 'paid' ? 'text-grey-900' : '' }}" style="font-size: 13px;">{{ $invoice->total_days }} hari</strong>
                            </div>
                            <div class="col-6">
                                <small class="{{ $invoice->status === 'paid' ? 'text-grey-900' : 'text-muted' }} d-block" style="font-size: 11px;">Total</small>
                                <strong class="{{ $invoice->status === 'paid' ? 'text-grey-900' : '' }}" style="font-size: 13px;">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <div class="mb-1">
                            <span class="badge {{ $invoice->status === 'paid' ? 'bg-white text-success' : 'bg-dark text-white' }}" style="font-size: 10px;">
                                {{ $invoice->status === 'paid' ? 'Lunas' : 'Belum Lunas' }}
                            </span>
                        </div>

                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info" style="padding: 0.15rem 0.4rem; font-size: 11px;">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-sm btn-danger" style="padding: 0.15rem 0.4rem; font-size: 11px;">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </a>
                            @if ($invoice->status === 'unpaid')
                                <form action="{{ route('invoices.status', $invoice) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="paid">
                                    <button type="submit" class="btn btn-sm btn-success" style="padding: 0.15rem 0.4rem; font-size: 11px;" onclick="return confirm('Tandai invoice ini sebagai Lunas?')">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('invoices.status', $invoice) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="unpaid">
                                    <button type="submit" class="btn btn-sm btn-secondary" style="padding: 0.15rem 0.4rem; font-size: 11px;" onclick="return confirm('Ubah status menjadi Belum Lunas?')">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-2">
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
@endsection
