@extends('layouts.app-admin')

@section('title', 'Tambah Katalog')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-plus-circle"></i> Tambah Katalog</h1>
            </div>

            <div class="section-body">
                <x-flash-message />
                <div class="row">
                    <div class="col-12">
                        <x-admin.card>
                            <div class="card-header">
                                <h4><i class="fas fa-book"></i> Form Katalog</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.store.catalog') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <x-admin.form-field label="Finalisasi Buku" name="final_id" required="true">
                                        <select class="form-control select2" tabindex="1" id="final_id"
                                            name="final_id" required>
                                            <option value="">-- Pilih Buku Final --</option>
                                            @foreach ($finalisasis as $finalisasi)
                                                <option value="{{ $finalisasi->id }}"
                                                    data-judul="{{ $finalisasi->buku->judul ?? '' }}"
                                                    data-isbn="{{ $finalisasi->isbn ?? '' }}"
                                                    @if (old('final_id') == $finalisasi->id) selected @endif>
                                                    {{ $finalisasi->buku->judul ?? 'Tanpa Judul' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Judul" name="judul" required="true">
                                        <input type="text" tabindex="2" class="form-control" id="judul"
                                            name="judul" value="{{ old('judul') }}" required placeholder="Judul buku katalog">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Pengarang" name="pengarang" required="true">
                                        <input type="text" tabindex="3" class="form-control" id="pengarang"
                                            name="pengarang" value="{{ old('pengarang') }}" required placeholder="Nama pengarang">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="ISBN" name="isbn" required="true">
                                        <input type="text" tabindex="4" class="form-control" id="isbn"
                                            name="isbn" value="{{ old('isbn') }}" required placeholder="ISBN">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Tahun Terbit" name="tahun_terbit" required="true">
                                        <input type="number" tabindex="5" class="form-control" id="tahun_terbit"
                                            name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" required placeholder="Contoh: {{ date('Y') }}">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Kategori" name="kategori" required="true">
                                        <input type="text" tabindex="6" class="form-control" id="kategori"
                                            name="kategori" value="{{ old('kategori') }}" required placeholder="Kategori katalog">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Deskripsi" name="deskripsi" required="true">
                                        <textarea tabindex="7" class="form-control" id="deskripsi"
                                            name="deskripsi" required placeholder="Deskripsi singkat buku">{{ old('deskripsi') }}</textarea>
                                    </x-admin.form-field>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                        <div class="col-sm-12 col-md-9">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                                Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </x-admin.card>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $('#final_id').on('change', function () {
            var selected = $(this).find(':selected');
            if (!$('#judul').val()) {
                $('#judul').val(selected.data('judul') || '');
            }
            if (!$('#isbn').val()) {
                $('#isbn').val(selected.data('isbn') || '');
            }
        }).trigger('change');
    </script>
@endpush
