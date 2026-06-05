@extends('layouts.app-admin')

@section('title', 'Tambah Royalti')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-coins"></i> Tambah Royalti</h1>
        </div>

        <div class="section-body">
            <x-flash-message />
            
            <div class="row">
                <div class="col-12">
                    <x-admin.card title="Form Royalti" icon="edit">
                        <form id="form-validation" action="{{ route('admin.store.royalty') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            
                            <x-admin.form-field label="Judul Buku" name="produksi_id" :required="true">
                                <select class="form-control select2" tabindex="1" id="produksi_id"
                                    name="produksi_id" value="{{ old('produksi_id') }}" style="width: 100%;">
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach ($produksi as $prod)
                                        @if ($prod->final->buku)
                                            <option value="{{ $prod->id }}"
                                                @if (old('produksi_id') == $prod->id) selected @endif>
                                                {{ $prod->final->buku->judul }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </x-admin.form-field>
                            
                            <x-admin.form-field label="Author" name="user_id" :required="true">
                                <select class="form-control select2" tabindex="2" id="user_id"
                                    name="user_id" value="{{ old('user_id') }}" style="width: 100%;">
                                    <option value="">-- Pilih Author --</option>
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}"
                                            @if (old('user_id') == $author->id) selected @endif>
                                            {{ $author->username }}
                                        </option>
                                    @endforeach
                                </select>
                            </x-admin.form-field>
                            
                            <x-admin.form-field label="Bab" name="bab_id" :required="true">
                                <select class="form-control select2" tabindex="3" id="bab_id"
                                    name="bab_id" value="{{ old('bab_id') }}" style="width: 100%;">
                                    <option value="">-- Pilih Bab --</option>
                                </select>
                            </x-admin.form-field>
                            
                            <x-admin.form-field label="Persentase (%)" name="persentase" :required="true">
                                <input type="number" tabindex="4" class="form-control" id="persentase"
                                    name="persentase" value="{{ old('persentase') }}" step="0.01" min="0" max="100"
                                    placeholder="Masukkan persentase royalti">
                            </x-admin.form-field>
                            
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                <div class="col-sm-12 col-md-10">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="far fa-save"></i> Simpan Royalti
                                    </button>
                                    <a href="{{ route('admin.index.royalty') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                language: 'id'
            });

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
                            } else {
                                $babSelect.append('<option value="" disabled>Tidak ada bab yang disetujui</option>');
                            }
                        }
                    });
                }
            }
            
            $('#produksi_id, #user_id').on('change', loadChapters);
        });
    </script>
@endpush
