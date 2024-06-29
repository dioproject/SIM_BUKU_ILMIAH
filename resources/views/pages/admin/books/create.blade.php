@extends('layouts.app-admin')

@section('title', 'Create Book')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Book</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Books</a></div>
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
                                <form id="create-book-form" action="{{ route('admin.store.book') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Category :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select class="form-control selectric" tabindex="1" id="category"
                                                name="category" value="{{ old('category') }}">
                                                @foreach ($category as $cate)
                                                    <option value="{{ $cate->id }}"
                                                        @if (old('category') == $cate->id) selected @endif>
                                                        {{ $cate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Title :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" tabindex="2" class="form-control" id="title"
                                                name="title" value="{{ old('title') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Script :</label>
                                            <div class="form-control custom-file col-sm-12 col-md-9">
                                                <input type="file" tabindex="5" name="path_foto" class="custom-file-input"
                                                    id="path_foto" value="{{ old('path_foto') }}" accept="image/*">
                                                <label class="custom-file-label">Choose File</label>
                                            </div>
                                            <div class="form-text text-muted">The image must have a maximum size of 1MB
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Abstract</label>
                                            <textarea class="summernote" tabindex="3" id="abstract" name="abstract" value="{{ old('abstract') }}"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Fill</label>
                                            <textarea class="summernote" tabindex="4" id="fill" name="fill" value="{{ old('fill') }}"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
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
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
@endpush
