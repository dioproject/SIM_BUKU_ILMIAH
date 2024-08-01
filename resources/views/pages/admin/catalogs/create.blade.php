@extends('layouts.app-admin')

@section('title', 'Create Catalog')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Catalog</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Catalogs</div>
                    <div class="breadcrumb-item">Create</div>
                </div>
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
                                <form action="{{ route('admin.store.catalog') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Title :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select class="form-control select2" tabindex="1" id="book_id"
                                                name="book_id" value="{{ old('book_id') }}">
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}"
                                                        @if (old('book_id') == $book->id) selected @endif>
                                                        {{ $book->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Cover :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="file" tabindex="2" name="cover"
                                                    class="form-control" id="cover" value="{{ old('cover') }}" accept=".jpg,.jpeg,.png">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Size :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" tabindex="3" class="form-control" id="size"
                                                name="size" value="{{ old('size') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Thickness :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="number" tabindex="4" class="form-control" id="thickness"
                                                name="thickness" value="{{ old('thickness') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Stock :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="number" tabindex="5" class="form-control" id="stock"
                                                name="stock" value="{{ old('stock') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Price :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="number" tabindex="5" class="form-control" id="price"
                                                name="price" value="{{ old('price') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                        <div class="col-sm-12 col-md-9">
                                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                                Submit</button>
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
@endpush
