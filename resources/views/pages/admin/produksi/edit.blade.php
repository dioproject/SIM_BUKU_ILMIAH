@extends('layouts.app-admin')

@section('title', 'Edit Produksi - ' . ($produksi->final->buku->judul ?? 'N/A'))

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-edit"></i> Edit Produksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.index.produksi') }}">Produksi</a></div>
                    <div class="breadcrumb-item active">Edit</div>
                </div>
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
                                <form action="{{ route('admin.update.produksi', $produksi->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <x-admin.form-field label="Judul Buku" name="final_id">
                                        <select class="form-control select2" tabindex="1" id="final_id"
                                            name="final_id" value="{{ old('final_id', $produksi->final_id) }}">
                                            @foreach ($finalisasis as $finali)
                                                @if ($finali->buku)
                                                    <option value="{{ $finali->id }}"
                                                        @if (old('final_id', $produksi->final_id) == $finali->id) selected @endif>
                                                        {{ $finali->buku->judul }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Eksemplar" name="eksemplar">
                                        <input type="text" tabindex="2" class="form-control" id="eksemplar"
                                            name="eksemplar" value="{{ old('eksemplar', $produksi->eksemplar) }}" placeholder="Jumlah eksemplar cetak">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Biaya Produksi" name="biaya_produksi">
                                        <input type="number" tabindex="3" class="form-control" id="biaya_produksi"
                                            name="biaya_produksi" value="{{ old('biaya_produksi', $produksi->biaya_produksi) }}" placeholder="Biaya produksi dalam Rupiah">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Harga Jual" name="harga_jual">
                                        <input type="number" tabindex="4" class="form-control" id="harga_jual"
                                            name="harga_jual" value="{{ old('harga_jual', $produksi->harga_jual) }}" placeholder="Harga jual dalam Rupiah">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Tahun Terbit" name="tahun_terbit">
                                        <input type="number" tabindex="5" class="form-control" id="tahun_terbit"
                                            name="tahun_terbit" value="{{ old('tahun_terbit', $produksi->tahun_terbit) }}" placeholder="Contoh: {{ date('Y') }}">
                                    </x-admin.form-field>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                        <div class="col-sm-12 col-md-9">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                                Simpan</button>
                                            <a href="{{ route('admin.index.produksi') }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Batal
                                            </a>
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
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                language: 'id'
            });
        });
    </script>
@endpush