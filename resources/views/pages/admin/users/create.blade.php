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
                                        <div class="row">
                                            <div class="col-auto">
                                                <select class="form-control" id="phone_region" name="phone_region">
                                                    <option value="+62" {{ old('phone_region', '+62') == '+62' ? 'selected' : '' }}>+62 (ID)</option>
                                                    <option value="+60" {{ old('phone_region') == '+60' ? 'selected' : '' }}>+60 (MY)</option>
                                                    <option value="+65" {{ old('phone_region') == '+65' ? 'selected' : '' }}>+65 (SG)</option>
                                                    <option value="+1" {{ old('phone_region') == '+1' ? 'selected' : '' }}>+1 (US/CA)</option>
                                                    <option value="+44" {{ old('phone_region') == '+44' ? 'selected' : '' }}>+44 (UK)</option>
                                                    <option value="+61" {{ old('phone_region') == '+61' ? 'selected' : '' }}>+61 (AU)</option>
                                                    <option value="+81" {{ old('phone_region') == '+81' ? 'selected' : '' }}>+81 (JP)</option>
                                                    <option value="+86" {{ old('phone_region') == '+86' ? 'selected' : '' }}>+86 (CN)</option>
                                                    <option value="+91" {{ old('phone_region') == '+91' ? 'selected' : '' }}>+91 (IN)</option>
                                                    <option value="+63" {{ old('phone_region') == '+63' ? 'selected' : '' }}>+63 (PH)</option>
                                                    <option value="+66" {{ old('phone_region') == '+66' ? 'selected' : '' }}>+66 (TH)</option>
                                                    <option value="+84" {{ old('phone_region') == '+84' ? 'selected' : '' }}>+84 (VN)</option>
                                                    <option value="+82" {{ old('phone_region') == '+82' ? 'selected' : '' }}>+82 (KR)</option>
                                                    <option value="+49" {{ old('phone_region') == '+49' ? 'selected' : '' }}>+49 (DE)</option>
                                                    <option value="+33" {{ old('phone_region') == '+33' ? 'selected' : '' }}>+33 (FR)</option>
                                                    <option value="+971" {{ old('phone_region') == '+971' ? 'selected' : '' }}>+971 (AE)</option>
                                                    <option value="+966" {{ old('phone_region') == '+966' ? 'selected' : '' }}>+966 (SA)</option>
                                                    <option value="+92" {{ old('phone_region') == '+92' ? 'selected' : '' }}>+92 (PK)</option>
                                                    <option value="+55" {{ old('phone_region') == '+55' ? 'selected' : '' }}>+55 (BR)</option>
                                                    <option value="+52" {{ old('phone_region') == '+52' ? 'selected' : '' }}>+52 (MX)</option>
                                                    <option value="+20" {{ old('phone_region') == '+20' ? 'selected' : '' }}>+20 (EG)</option>
                                                    <option value="+27" {{ old('phone_region') == '+27' ? 'selected' : '' }}>+27 (ZA)</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="tel" tabindex="5" class="form-control" id="contact"
                                                    name="contact" value="{{ old('contact') }}" placeholder="Masukkan nomor kontak"
                                                    pattern="[0-9]{6,15}" title="Hanya angka, 6-15 digit">
                                            </div>
                                        </div>
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
