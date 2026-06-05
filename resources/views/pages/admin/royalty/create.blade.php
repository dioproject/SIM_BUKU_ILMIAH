@extends('layouts.app-admin')

@section('title', 'Tambah Royalti')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Royalti</h1>
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
                                <form id="form-validation" action="{{ route('admin.store.royalty') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Judul Buku
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select class="form-control select2" tabindex="1" id="produksi_id"
                                                name="produksi_id" value="{{ old('produksi_id') }}">
                                                @foreach ($produksi as $prod)
                                                    @if ($prod->final->buku)
                                                        <option value="{{ $prod->id }}"
                                                            @if (old('produksi_id') == $prod->id) selected @endif>
                                                            {{ $prod->final->buku->judul }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Author
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select class="form-control select2" tabindex="2" id="user_id"
                                                name="user_id" value="{{ old('user_id') }}">
                                                @foreach ($authors as $author)
                                                    <option value="{{ $author->id }}"
                                                        @if (old('user_id') == $author->id) selected @endif>
                                                        {{ $author->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Bab
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select class="form-control select2" tabindex="3" id="bab_id"
                                                name="bab_id" value="{{ old('bab_id') }}">
                                                <option value="">-- Pilih Bab --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Persentase (%)
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="number" tabindex="4" class="form-control" id="persentase"
                                                name="persentase" value="{{ old('persentase') }}" step="0.01" min="0" max="100">
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Load chapters when author and book are selected
            function loadChapters() {
                var produksiId = $('#produksi_id').val();
                var userId = $('#user_id').val();
                
                if (produksiId && userId) {
                    $.ajax({
                        url: '/admin/api/chapters-by-produksi-author',
                        method: 'GET',
                        data: {
                            produksi_id: produksiId,
                            user_id: userId
                        },
                        success: function(response) {
                            var $babSelect = $('#bab_id');
                            $babSelect.empty();
                            $babSelect.append('<option value="">-- Pilih Bab --</option>');
                            
                            if (response.chapters && response.chapters.length > 0) {
                                response.chapters.forEach(function(chapter) {
                                    $babSelect.append('<option value="' + chapter.id + '">' + chapter.nama + '</option>');
                                });
                            }
                        }
                    });
                }
            }
            
            $('#produksi_id, #user_id').on('change', loadChapters);
            
            // Initial load
            loadChapters();
        });
    </script>
@endpush
