@extends('layouts.app')

@section('title', 'Presensi - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-0">
                    @if ($isCheckIn)
                        Check In
                    @elseif ($isCheckOut)
                        Check Out
                    @else
                        Presensi Selesai
                    @endif
                </h6>
            </div>
        </div>

        @if ($isCheckIn || $isCheckOut)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <video id="video" class="w-100 rounded" style="max-height: 300px; object-fit: cover;" autoplay playsinline></video>
                        <canvas id="canvas" class="d-none"></canvas>
                        <img id="photo-preview" class="w-100 rounded d-none" style="max-height: 300px; object-fit: cover;">
                    </div>

                    <div class="d-flex gap-2 mb-3">
                        <button type="button" id="btn-capture" class="btn btn-primary w-100">
                            <i class="bi bi-camera"></i> Ambil Foto
                        </button>
                        <button type="button" id="btn-retake" class="btn btn-secondary w-100 d-none">
                            <i class="bi bi-arrow-counterclockwise"></i> Ulangi
                        </button>
                    </div>

                    <div id="location-info" class="alert alert-info d-none">
                        <i class="bi bi-geo-alt"></i> <span id="location-text">Mengambil lokasi...</span>
                    </div>

                    <form action="{{ $isCheckIn ? route('attendances.store') : route('attendances.update', $attendance) }}" method="POST" id="attendanceForm">
                        @csrf
                        @if ($isCheckOut)
                            @method('PUT')
                        @endif

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="photo" id="photo">

                        <button type="submit" id="btn-submit" class="btn btn-success w-100" disabled>
                            @if ($isCheckIn)
                                <i class="bi bi-box-arrow-in-right"></i> Check In
                            @else
                                <i class="bi bi-box-arrow-right"></i> Check Out
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    <h5 class="mt-3">Presensi Hari Ini Selesai</h5>
                    <p class="text-muted">Anda sudah melakukan check in dan check out hari ini.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const photoPreview = document.getElementById('photo-preview');
            const btnCapture = document.getElementById('btn-capture');
            const btnRetake = document.getElementById('btn-retake');
            const btnSubmit = document.getElementById('btn-submit');
            const photoInput = document.getElementById('photo');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const locationInfo = document.getElementById('location-info');
            const locationText = document.getElementById('location-text');

            let stream = null;
            let photoTaken = false;
            let locationReady = false;

            // Akses kamera
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                    .then(function (s) {
                        stream = s;
                        video.srcObject = stream;
                    })
                    .catch(function (err) {
                        console.error('Error accessing camera:', err);
                        alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin kamera.');
                    });
            } else {
                alert('Browser tidak mendukung akses kamera.');
            }

            // Ambil lokasi
            if (navigator.geolocation) {
                locationInfo.classList.remove('d-none');
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        latitudeInput.value = position.coords.latitude;
                        longitudeInput.value = position.coords.longitude;
                        locationText.textContent = 'Lokasi berhasil diambil';
                        locationInfo.classList.remove('alert-info');
                        locationInfo.classList.add('alert-success');
                        locationReady = true;
                        checkReady();
                    },
                    function (error) {
                        console.error('Error getting location:', error);
                        locationText.textContent = 'Gagal mengambil lokasi. Pastikan GPS aktif.';
                        locationInfo.classList.remove('alert-info');
                        locationInfo.classList.add('alert-danger');
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                alert('Browser tidak mendukung geolocation.');
            }

            // Ambil foto
            btnCapture.addEventListener('click', function () {
                if (!stream) return;

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const dataUrl = canvas.toDataURL('image/jpeg', 0.8);
                photoInput.value = dataUrl;

                photoPreview.src = dataUrl;
                photoPreview.classList.remove('d-none');
                video.classList.add('d-none');

                btnCapture.classList.add('d-none');
                btnRetake.classList.remove('d-none');

                photoTaken = true;
                checkReady();
            });

            // Ulangi foto
            btnRetake.addEventListener('click', function () {
                photoPreview.classList.add('d-none');
                video.classList.remove('d-none');
                btnCapture.classList.remove('d-none');
                btnRetake.classList.add('d-none');
                photoInput.value = '';
                photoTaken = false;
                checkReady();
            });

            function checkReady() {
                if (photoTaken && locationReady) {
                    btnSubmit.disabled = false;
                } else {
                    btnSubmit.disabled = true;
                }
            }
        });
    </script>
@endpush
