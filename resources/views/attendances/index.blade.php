@extends('layouts.app')

@section('title', 'Presensi - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card mb-3">
            <div class="card-body d-flex align-items-center justify-content-between">
                <h6 class="mb-0">Data Presensi</h6>
                <a href="{{ route('attendances.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Presensi
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100" id="dataTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Photo In</th>
                                <th>Photo Out</th>
                                <th>Lokasi In</th>
                                <th>Lokasi Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr>
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
                                        @if ($attendance->check_in_photo)
                                            <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" alt="Photo In" class="img-thumbnail" style="max-width: 50px;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attendance->check_out_photo)
                                            <img src="{{ asset('storage/' . $attendance->check_out_photo) }}" alt="Photo Out" class="img-thumbnail" style="max-width: 50px;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attendance->check_in_latitude && $attendance->check_in_longitude)
                                            <a href="https://maps.google.com/?q={{ $attendance->check_in_latitude }},{{ $attendance->check_in_longitude }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="bi bi-geo-alt"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($attendance->check_out_latitude && $attendance->check_out_longitude)
                                            <a href="https://maps.google.com/?q={{ $attendance->check_out_latitude }},{{ $attendance->check_out_longitude }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="bi bi-geo-alt"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('dataTable')) {
                new DataTable('#dataTable', {
                    paging: false,
                    searchable: false,
                });
            }
        });
    </script>
@endpush
