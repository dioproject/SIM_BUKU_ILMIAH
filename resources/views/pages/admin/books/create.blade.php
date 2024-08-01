@extends('layouts.app-admin')

@section('title', 'Tambah Buku')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Buku</h1>
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
                                <form id="create-book-form" action="{{ route('admin.store.book') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Jenis Buku
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select class="form-control select2" tabindex="1" id="jenis_id"
                                                name="jenis_id" value="{{ old('jenis_id') }}">
                                                @foreach ($jenis as $jenis)
                                                    <option value="{{ $jenis->id }}"
                                                        @if (old('jenis_id') == $jenis->id) selected @endif>
                                                        {{ $jenis->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Judul :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" tabindex="2" class="form-control" id="judul"
                                                name="judul" value="{{ old('judul') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Template
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="file" tabindex="3" class="form-control" id="template"
                                                name="template" value="{{ old('template') }}" accept=".doc,.docx">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Total Bab
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="number" tabindex="4" class="form-control" id="total_bab"
                                                name="total_bab" value="{{ old('total_bab') }}" accept=".doc,.docx">
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
