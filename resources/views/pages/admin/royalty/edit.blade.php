@extends('layouts.app-admin')

@section('title', 'Edit Royalti')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-coins"></i> Edit Royalti</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">Royalti</div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <x-flash-message />
            <div class="row">
                <div class="col-12">
                    <x-admin.card title="Edit Royalti" icon="edit">
                        <form id="create-user-form" action="{{ route('admin.update.royalty', $royalty->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <x-admin.form-field label="Penulis" for="author_id" :cols="6">
                                    <select class="form-control select2" tabindex="1" id="author_id"
                                        name="author_id">
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}"
                                                {{ $royalty->author_id == $author->id ? 'selected' : '' }}>
                                                {{ $author->username }}</option>
                                        @endforeach
                                    </select>
                                </x-admin.form-field>
                                <x-admin.form-field label="Judul Buku" for="book_id" :cols="6">
                                    <select class="form-control select2" tabindex="2" id="book_id"
                                        name="book_id">
                                        @foreach ($books as $book)
                                            <option value="{{ $book->id }}"
                                                {{ $royalty->book_id == $book->id ? 'selected' : '' }}>
                                                {{ $book->judul }}</option>
                                        @endforeach
                                    </select>
                                </x-admin.form-field>
                                <x-admin.form-field label="Harga Jual" for="harga_jual" :cols="6">
                                    <input type="number" class="form-control" name="harga_jual" id="harga_jual"
                                        value="{{ $royalty->harga_jual }}" required>
                                </x-admin.form-field>
                                <x-admin.form-field label="Biaya Produksi" for="biaya_produksi" :cols="6">
                                    <input type="number" class="form-control" name="biaya_produksi" id="biaya_produksi"
                                        value="{{ $royalty->biaya_produksi }}" required>
                                </x-admin.form-field>
                                <x-admin.form-field label="Jumlah Cetak" for="jml_print" :cols="6">
                                    <input type="number" class="form-control" name="jml_print" id="jml_print"
                                        value="{{ $royalty->jml_print }}" required>
                                </x-admin.form-field>
                                <x-admin.form-field label="Persentase Royalti (%)" for="persentase" :cols="6">
                                    <input type="number" class="form-control" name="persentase" id="persentase"
                                        value="{{ $royalty->persentase }}" required>
                                </x-admin.form-field>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Perbarui Royalti
                                </button>
                                <a href="{{ route('admin.index.royalty') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
