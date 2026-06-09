@extends('layouts.app')

@section('title', 'Profile - Presensi App')

@section('content')
    <div class="container pt-3">
        <div class="card user-info-card mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="user-profile me-3">
                    <img src="{{ asset('assets/img/logo/profile.png') }}" alt="">
                </div>
                <div class="user-info">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                    </div>
                    <p class="mb-0">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <div class="card user-data-card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label class="form-label" for="name">Nama Lengkap</label>
                        <input class="form-control" id="name" type="text" name="name" value="{{ auth()->user()->name }}" placeholder="Nama Lengkap" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" type="email" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <hr class="my-4">

                    <h6 class="mb-3">Ubah Password</h6>

                    <div class="form-group mb-3">
                        <label class="form-label" for="password">Password Baru</label>
                        <input class="form-control" id="password" type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                        <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
