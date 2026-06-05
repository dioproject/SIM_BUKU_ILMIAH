@extends('layouts.auth')

@section('title', 'Daftar Akun')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4><i class="fas fa-user-plus"></i> Daftar Akun</h4>
        </div>

        <div class="card-body">
            <form id="form-validation" action="{{ route('register.action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" type="text" class="form-control" name="name" tabindex="1" required
                        autofocus placeholder="Masukkan nama lengkap Anda">
                    <div class="invalid-feedback">
                        Silakan masukkan nama Anda
                    </div>
                </div>
                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="2" required
                        autofocus placeholder="Masukkan nama pengguna Anda">
                    <div class="invalid-feedback">
                        Silakan masukkan nama pengguna Anda
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="3" required
                        autofocus placeholder="Masukkan email Anda">
                    <div class="invalid-feedback">
                        Silakan masukkan email Anda
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact">Kontak</label>
                    <input id="contact" type="number" class="form-control" name="contact" tabindex="4" required
                        autofocus placeholder="Masukkan nomor kontak Anda">
                    <div class="invalid-feedback">
                        Silakan masukkan kontak Anda
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input id="password" type="password" class="form-control" name="password" tabindex="5" required
                        placeholder="Masukkan kata sandi Anda">
                    <div class="invalid-feedback">
                        Silakan masukkan kata sandi Anda
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" tabindex="6" required
                        placeholder="Ulangi kata sandi Anda">
                    <div class="invalid-feedback">
                        Silakan konfirmasi kata sandi Anda
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        <i class="fas fa-user-plus"></i> Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-muted mt-5 text-center">
        Sudah punya akun? <a href="/login">Masuk</a>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('js/page/register.js') }}"></script>
@endpush
