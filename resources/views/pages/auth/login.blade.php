@extends('layouts.auth')

@section('title', 'Masuk')

@push('style')
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4><i class="fas fa-sign-in-alt"></i> Masuk</h4>
        </div>

        <div class="card-body">
            <form 
                id="form_validation"
                action="{{ route('login.action') }}" 
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email"
                        type="email"
                        class="form-control"
                        name="email"
                        tabindex="1"
                        required
                        autofocus
                        placeholder="Masukkan email Anda">
                    <div class="invalid-feedback">
                        Silakan masukkan email Anda
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input id="password"
                        type="password"
                        class="form-control"
                        name="password"
                        tabindex="2"
                        required
                        placeholder="Masukkan kata sandi Anda">
                    <div class="invalid-feedback">
                        Silakan masukkan kata sandi Anda
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit"
                        class="btn btn-primary btn-lg btn-block"
                        tabindex="4">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
    {{-- <div class="text-muted mt-5 text-center">
        Sudah punya akun? <a href="{{ route('register') }}">Daftar</a>
    </div> --}}
@endsection

@push('scripts')
@endpush
