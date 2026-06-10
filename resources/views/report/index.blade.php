@extends('layouts.app')

@section('title', 'Report Presensi - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card mb-2">
            <div class="card-body">
                <h6 class="mb-2">Filter Periode</h6>
                <form action="{{ route('report.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label" for="date_from" style="font-size: 12px;">Dari Tanggal</label>
                            <input class="form-control form-control-sm" type="date" id="date_from" name="date_from" value="{{ $dateFrom }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="date_to" style="font-size: 12px;">Sampai Tanggal</label>
                            <input class="form-control form-control-sm" type="date" id="date_to" name="date_to" value="{{ $dateTo }}" required>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mt-2 btn-sm" type="submit">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                </form>
            </div>
        </div>

        <!-- Summary -->
        <div class="row g-2 mb-2">
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center p-2">
                        <h6 class="mb-0">{{ $totalDays }}</h6>
                        <small class="text-muted" style="font-size: 11px;">Hadir</small>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center p-2">
                        <h6 class="mb-0">{{ $totalCheckIn }}</h6>
                        <small class="text-muted" style="font-size: 11px;">Check In</small>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center p-2">
                        <h6 class="mb-0">{{ $totalCheckOut }}</h6>
                        <small class="text-muted" style="font-size: 11px;">Check Out</small>
                    </div>
                </div>
            </div>
        </div>

        @if ($avgCheckIn)
            <div class="card mb-2">
                <div class="card-body p-2">
                    <div class="row g-2 text-center">
                        <div class="col-6">
                            <small class="text-muted d-block" style="font-size: 11px;">Rata-rata Check In</small>
                            <strong style="font-size: 13px;">{{ \Carbon\Carbon::createFromTimestamp($avgCheckIn)->format('H:i') }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block" style="font-size: 11px;">Rata-rata Check Out</small>
                            <strong style="font-size: 13px;">{{ $avgCheckOut ? \Carbon\Carbon::createFromTimestamp($avgCheckOut)->format('H:i') : '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Detail Cards -->
        @if ($attendances->count() > 0)
            <div class="card mb-2">
                <div class="card-body p-2">
                    <h6 class="mb-0" style="font-size: 14px;">Detail Presensi</h6>
                </div>
            </div>

            @foreach ($attendances as $attendance)
                <div class="card timeline-card mb-2">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="timeline-text mb-1">
                                <span class="badge bg-primary mb-1 rounded-pill" style="font-size: 10px;">{{ $attendance->date->format('d M Y') }}</span>
                                <h6 class="mb-0" style="font-size: 14px;">Detail Harian</h6>
                            </div>
                            <div class="timeline-icon mb-1">
                                <i class="bi bi-file-earmark-bar-graph h4 mb-0 text-primary"></i>
                            </div>
                        </div>

                        <div class="row g-1 mb-1">
                            <div class="col-6">
                                <small class="text-muted d-block" style="font-size: 11px;">Check In</small>
                                @if ($attendance->check_in_at)
                                    <strong class="text-success" style="font-size: 13px;">{{ $attendance->check_in_at->format('H:i') }}</strong>
                                    <br>
                                    <small class="text-muted" style="font-size: 10px;">{{ $attendance->check_in_latitude }}, {{ $attendance->check_in_longitude }}</small>
                                @else
                                    <span class="text-muted" style="font-size: 13px;">-</span>
                                @endif
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block" style="font-size: 11px;">Check Out</small>
                                @if ($attendance->check_out_at)
                                    <strong class="text-danger" style="font-size: 13px;">{{ $attendance->check_out_at->format('H:i') }}</strong>
                                    <br>
                                    <small class="text-muted" style="font-size: 10px;">{{ $attendance->check_out_latitude }}, {{ $attendance->check_out_longitude }}</small>
                                @else
                                    <span class="text-muted" style="font-size: 13px;">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="timeline-tags">
                            @if ($attendance->check_in_at && $attendance->check_out_at)
                                <span class="badge fw-normal bg-primary" style="font-size: 10px;">
                                    <i class="bi bi-clock"></i>
                                    {{ number_format($attendance->check_in_at->diffInMinutes($attendance->check_out_at) / 60, 2, ',', '.') }} jam
                                </span>
                            @else
                                <span class="badge fw-normal bg-secondary" style="font-size: 10px;">Belum lengkap</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card">
                <div class="card-body text-center p-2">
                    <p class="text-muted mb-0" style="font-size: 13px;">Tidak ada data presensi pada periode ini</p>
                </div>
            </div>
        @endif
    </div>
@endsection
