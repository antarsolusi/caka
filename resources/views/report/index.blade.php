@extends('layouts.app')

@section('title', 'Report Presensi - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-3">Filter Periode</h6>
                <form action="{{ route('report.index') }}" method="GET">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label" for="date_from">Dari Tanggal</label>
                            <input class="form-control" type="date" id="date_from" name="date_from" value="{{ $dateFrom }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="date_to">Sampai Tanggal</label>
                            <input class="form-control" type="date" id="date_to" name="date_to" value="{{ $dateTo }}" required>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mt-3" type="submit">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                </form>
            </div>
        </div>

        <!-- Summary -->
        <div class="row g-3 mb-3">
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="mb-0">{{ $totalDays }}</h5>
                        <small class="text-muted">Hadir</small>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="mb-0">{{ $totalCheckIn }}</h5>
                        <small class="text-muted">Check In</small>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="mb-0">{{ $totalCheckOut }}</h5>
                        <small class="text-muted">Check Out</small>
                    </div>
                </div>
            </div>
        </div>

        @if ($avgCheckIn)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-2 text-center">
                        <div class="col-6">
                            <small class="text-muted d-block">Rata-rata Check In</small>
                            <strong>{{ \Carbon\Carbon::createFromTimestamp($avgCheckIn)->format('H:i') }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Rata-rata Check Out</small>
                            <strong>{{ $avgCheckOut ? \Carbon\Carbon::createFromTimestamp($avgCheckOut)->format('H:i') : '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Detail Table -->
        <div class="card">
            <div class="card-body">
                <h6 class="mb-3">Detail Presensi</h6>

                @if ($attendances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Durasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($attendance->check_in_at)
                                                <span class="text-success">{{ $attendance->check_in_at->format('H:i') }}</span>
                                                <br>
                                                <small class="text-muted">{{ $attendance->check_in_latitude }}, {{ $attendance->check_in_longitude }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($attendance->check_out_at)
                                                <span class="text-danger">{{ $attendance->check_out_at->format('H:i') }}</span>
                                                <br>
                                                <small class="text-muted">{{ $attendance->check_out_latitude }}, {{ $attendance->check_out_longitude }}</small>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($attendance->check_in_at && $attendance->check_out_at)
                                                {{ number_format($attendance->check_in_at->diffInMinutes($attendance->check_out_at) / 60, 2, ',', '.') }} jam 
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center mb-0">Tidak ada data presensi pada periode ini</p>
                @endif
            </div>
        </div>
    </div>
@endsection
