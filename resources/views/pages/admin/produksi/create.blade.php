@extends('layouts.app-admin')

@section('title', 'Tambah Produksi')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-plus-circle"></i> Tambah Produksi</h1>
            </div>

            <div class="section-body">
                <x-flash-message />
                <div class="row">
                    <div class="col-12">
                        <x-admin.card>
                            <div class="card-header">
                                <h4><i class="fas fa-industry"></i> Form Produksi</h4>
                            </div>
                            <div class="card-body">
                                <form id="create-book-form" action="{{ route('admin.store.produksi') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <x-admin.form-field label="Judul Buku" name="final_id">
                                        <select class="form-control select2" tabindex="1" id="final_id"
                                            name="final_id" value="{{ old('final_id') }}">
                                            @foreach ($finalisasis as $finali)
                                                @if ($finali->buku)
                                                    <option value="{{ $finali->id }}"
                                                        @if (old('final_id') == $finali->id) selected @endif>
                                                        {{ $finali->buku->judul }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Eksemplar" name="eksemplar">
                                        <input type="text" tabindex="2" class="form-control" id="eksemplar"
                                            name="eksemplar" value="{{ old('eksemplar') }}" placeholder="Jumlah eksemplar cetak">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Biaya Produksi" name="biaya_produksi">
                                        <input type="number" tabindex="3" class="form-control" id="biaya_produksi"
                                            name="biaya_produksi" value="{{ old('biaya_produksi') }}" placeholder="Biaya produksi dalam Rupiah">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Harga Jual" name="harga_jual">
                                        <input type="number" tabindex="4" class="form-control" id="harga_jual"
                                            name="harga_jual" value="{{ old('harga_jual') }}" placeholder="Harga jual dalam Rupiah">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Tahun Terbit" name="tahun_terbit">
                                        <input type="number" tabindex="5" class="form-control" id="tahun_terbit"
                                            name="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" placeholder="Contoh: {{ date('Y') }}">
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush
