@extends('layouts.app-admin')

@section('title', 'Tambah Pengguna')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-user-plus"></i> Tambah Pengguna</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <x-admin.card title="Tambah Pengguna" icon="user-plus">
                            <x-flash-message />
                            <form id="create-user-form" action="{{ route('admin.store.user') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row mb-4">
                                    <label
                                        class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Nama Pengguna</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" tabindex="1" class="form-control" id="username"
                                            name="username" value="{{ old('username') }}" placeholder="Masukkan nama pengguna">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Nama Lengkap</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="text" tabindex="2" class="form-control" id="name"
                                            name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Email</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="email" tabindex="3" class="form-control" id="email"
                                            name="email" value="{{ old('email') }}" placeholder="Masukkan alamat email">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label
                                        class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Kata Sandi</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="password" tabindex="4" class="form-control" id="password"
                                            name="password" placeholder="Masukkan kata sandi">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Kontak</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input type="number" tabindex="5" class="form-control" id="contact"
                                            name="contact" value="{{ old('contact') }}" placeholder="Masukkan nomor kontak">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Peran</label>
                                    <div class="col-sm-12 col-md-10">
                                        <select class="form-control selectric" tabindex="6" id="user_role"
                                            name="user_role" value="{{ old('user_role') }}">
                                            <option value="ADMIN" {{ old('user_role') == 'ADMIN' ? 'selected' : '' }}>
                                                ADMIN</option>
                                            <option value="REVIEWER" {{ old('user_role') == 'REVIEWER' ? 'selected' : '' }}>
                                                REVIEWER</option>
                                            <option value="AUTHOR"
                                                {{ old('user_role') == 'AUTHOR' ? 'selected' : '' }}>AUTHOR
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                    <div class="col-sm-12 col-md-9">
                                        <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                            Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </x-admin.card>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
