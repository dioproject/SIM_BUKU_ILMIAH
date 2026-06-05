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
                                    <x-admin.form-field label="Judul Buku" name="book_id">
                                        <select class="form-control select2" tabindex="1" id="book_id"
                                            name="book_id" value="{{ old('book_id') }}">
                                            @foreach ($books as $book)
                                                <option value="{{ $book->id }}"
                                                    @if (old('book_id') == $book->id) selected @endif>
                                                    {{ $book->judul }}</option>
                                            @endforeach
                                        </select>
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Sampul" name="cover">
                                        <input type="file" tabindex="2" name="cover"
                                                class="form-control" id="cover" value="{{ old('cover') }}" accept=".jpg,.jpeg,.png" placeholder="Pilih file sampul">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Ukuran" name="size">
                                        <input type="text" tabindex="3" class="form-control" id="size"
                                            name="size" value="{{ old('size') }}" placeholder="Contoh: 15.5 x 23 cm">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Tebal" name="thickness">
                                        <input type="number" tabindex="4" class="form-control" id="thickness"
                                            name="thickness" value="{{ old('thickness') }}" placeholder="Jumlah halaman">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Stok" name="stock">
                                        <input type="number" tabindex="5" class="form-control" id="stock"
                                            name="stock" value="{{ old('stock') }}" placeholder="Jumlah stok">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Harga" name="price">
                                        <input type="number" tabindex="5" class="form-control" id="price"
                                            name="price" value="{{ old('price') }}" placeholder="Harga dalam Rupiah">
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
@endpush
