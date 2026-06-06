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
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select class="form-control" id="phone_region" name="phone_region" style="width: auto; border-top-right-radius: 0; border-bottom-right-radius: 0;">
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
                        <input id="contact" type="tel" class="form-control" name="contact" tabindex="4" required
                            autofocus placeholder="Masukkan nomor kontak Anda"
                            pattern="[0-9]{6,15}" title="Hanya angka, 6-15 digit">
                    </div>
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
