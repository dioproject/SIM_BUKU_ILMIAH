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
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Title</label>
                                            <select class="form-control select2" tabindex="1" id="book_id"
                                                name="book_id" value="{{ old('book_id') }}">
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}"
                                                        @if (old('book_id') == $book->id) selected @endif>
                                                        {{ $book->manuscript->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Photos</label>
                                            <div class="form-control custom-file">
                                                <input type="file" tabindex="2" name="path_foto"
                                                    class="custom-file-input" id="path_foto" value="{{ old('path_foto') }}" accept="image/*">
                                                <label class="custom-file-label">Choose File</label>
                                            </div>
                                            <div class="form-text text-muted">The image must have a maximum size of 1MB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea type="text" tabindex="3" id="description" name="description" class="form-control"
                                                value="{{ old('description') }}" data-height="150"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
