@extends('layouts.app')

@section('title', 'Presensi - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card mb-2">
            <div class="card-body d-flex align-items-center justify-content-between">
                <h6 class="mb-0">Data Presensi</h6>
                <a href="{{ route('attendances.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Presensi
                </a>
            </div>
        </div>

        @foreach ($attendances as $attendance)
            <div class="card timeline-card mb-2">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="timeline-text mb-1">
                            <span class="badge bg-primary mb-1 rounded-pill" style="font-size: 10px;">{{ $attendance->date->format('d M Y') }}</span>
                            <h6 class="mb-0" style="font-size: 14px;">Presensi Harian</h6>
                        </div>
                        <div class="timeline-icon mb-1">
                            <i class="bi bi-calendar-check h4 mb-0 text-primary"></i>
                        </div>
                    </div>

                    <div class="row g-1 mb-1">
                        <div class="col-6">
                            <small class="text-muted d-block" style="font-size: 11px;">Check In</small>
                            @if ($attendance->check_in_at)
                                <strong class="text-success" style="font-size: 13px;">{{ $attendance->check_in_at->format('H:i') }}</strong>
                            @else
                                <span class="text-muted" style="font-size: 13px;">-</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block" style="font-size: 11px;">Check Out</small>
                            @if ($attendance->check_out_at)
                                <strong class="text-danger" style="font-size: 13px;">{{ $attendance->check_out_at->format('H:i') }}</strong>
                            @else
                                <span class="text-muted" style="font-size: 13px;">-</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-1 mb-1">
                        <div class="col-6">
                            <small class="text-muted d-block" style="font-size: 11px;">Photo In</small>
                            @if ($attendance->check_in_photo)
                                <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" alt="Photo In" class="img-thumbnail" style="max-width: 40px; max-height: 40px;">
                            @else
                                <span class="text-muted" style="font-size: 13px;">-</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block" style="font-size: 11px;">Photo Out</small>
                            @if ($attendance->check_out_photo)
                                <img src="{{ asset('storage/' . $attendance->check_out_photo) }}" alt="Photo Out" class="img-thumbnail" style="max-width: 40px; max-height: 40px;">
                            @else
                                <span class="text-muted" style="font-size: 13px;">-</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-1 flex-wrap">
                        @if ($attendance->check_in_latitude && $attendance->check_in_longitude)
                            <a href="https://maps.google.com/?q={{ $attendance->check_in_latitude }},{{ $attendance->check_in_longitude }}" target="_blank" class="btn btn-sm btn-info" style="padding: 0.15rem 0.4rem; font-size: 11px;">
                                <i class="bi bi-geo-alt"></i> In
                            </a>
                        @endif
                        @if ($attendance->check_out_latitude && $attendance->check_out_longitude)
                            <a href="https://maps.google.com/?q={{ $attendance->check_out_latitude }},{{ $attendance->check_out_longitude }}" target="_blank" class="btn btn-sm btn-info" style="padding: 0.15rem 0.4rem; font-size: 11px;">
                                <i class="bi bi-geo-alt"></i> Out
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-2">
            {{ $attendances->links() }}
        </div>
    </div>
@endsection
