@extends('layouts.app')

@section('title', 'Buat Invoice - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-0">Buat Invoice</h6>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($attendances->count() > 0)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row g-2 text-center">
                        <div class="col-6">
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <h5 class="mb-0">{{ $totalDays }} Hari</h5>
                                    <small class="text-muted">Jumlah Kehadiran</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <h5 class="mb-0">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h5>
                                    <small class="text-muted">Total Nominal</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="mb-0">Pilih Kehadiran</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">Pilih Semua</label>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">#</th>
                                        <th>Tanggal</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr>
                                            <td>
                                                <input class="form-check-input attendance-checkbox" type="checkbox"
                                                    name="attendance_ids[]" value="{{ $attendance->id }}"
                                                    id="attendance_{{ $attendance->id }}">
                                            </td>
                                            <td>
                                                <label for="attendance_{{ $attendance->id }}" class="d-block mb-0">
                                                    {{ $attendance->date->format('d/m/Y') }}
                                                </label>
                                            </td>
                                            <td>
                                                @if($attendance->check_in_at)
                                                    {{ $attendance->check_in_at->format('H:i') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>   
                                            <td>
                                                @if($attendance->check_out_at)
                                                    {{ $attendance->check_out_at->format('H:i') }}
                                               
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @error('attendance_ids')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-success w-100 mt-3">
                            <i class="bi bi-receipt"></i> Buat Invoice
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="card">
                <div class="card-body text-center py-4">
                    <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2 mb-0">Tidak ada kehadiran yang belum di-invoice</p>
                    <p class="text-muted small">Pastikan Anda sudah melakukan check in dan check out</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.attendance-checkbox');

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(cb => cb.checked = selectAll.checked);
                });
            }
        });
    </script>
@endpush
