@extends('layouts.app-admin')

@section('title', 'Tambah Produksi')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Produksi</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form id="create-book-form" action="{{ route('admin.store.produksi') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Judul Buku
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
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
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Eksemplar
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" tabindex="2" class="form-control" id="eksemplar"
                                                name="eksemplar" value="{{ old('eksemplar') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Biaya Produksi
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="number" tabindex="3" class="form-control" id="biaya_produksi"
                                                name="biaya_produksi" value="{{ old('biaya_produksi') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Keuntungan
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="number" tabindex="4" class="form-control" id="keuntungan"
                                                name="keuntungan" value="{{ old('keuntungan') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                        <div class="col-sm-12 col-md-9">
                                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                                Tambah</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush
