@extends('layouts.app')

@section('title', 'Dashboard - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card bg-primary mb-3 bg-img" style="background-image: url('{{ asset('assets/img/core-img/1.png') }}')">
            <div class="card-body direction-rtl p-4">
                <h2 class="text-white mb-1">Halo, {{ auth()->user()->name }}</h2>
                <p class="mb-0 text-white">{{ now()->format('l, d F Y') }}</p>
            </div>
        </div>

        <!-- Status Hari Ini -->
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-2">Status Hari Ini</h6>
                @if ($todayAttendance)
                    @if ($todayAttendance->check_out_at)
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle-fill"></i> Sudah Check Out pada {{ $todayAttendance->check_out_at->format('H:i') }}
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-clock-fill"></i> Sudah Check In pada {{ $todayAttendance->check_in_at->format('H:i') }}
                        </div>
                        <a href="{{ route('attendances.create') }}" class="btn btn-danger w-100 mt-2">
                            <i class="bi bi-box-arrow-right"></i> Check Out Sekarang
                        </a>
                    @endif
                @else
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle-fill"></i> Belum melakukan presensi hari ini
                    </div>
                    <a href="{{ route('attendances.create') }}" class="btn btn-primary w-100 mt-2">
                        <i class="bi bi-box-arrow-in-right"></i> Check In Sekarang
                    </a>
                @endif
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-3">
            <div class="col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <i class="bi bi-calendar-check text-primary" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-0">{{ $totalThisMonth }}</h4>
                        <small class="text-muted">Presensi Bulan Ini</small>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <i class="bi bi-journal-check text-success" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-0">{{ $totalAll }}</h4>
                        <small class="text-muted">Total Presensi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Presensi Terakhir -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="mb-0">Presensi Terakhir</h6>
                    <a href="{{ route('attendances.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>

                @if ($recentAttendances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentAttendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->date->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($attendance->check_in_at)
                                                {{ $attendance->check_in_at->format('H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($attendance->check_out_at)
                                                {{ $attendance->check_out_at->format('H:i') }}
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
                    <p class="text-muted text-center mb-0">Belum ada data presensi</p>
                @endif
            </div>
        </div>
    </div>
@endsection
