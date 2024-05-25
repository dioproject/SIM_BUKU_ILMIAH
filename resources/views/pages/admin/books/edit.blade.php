@extends('layouts.app-admin')

@section('title', 'Edit Book')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Book</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Data</div>
                    <div class="breadcrumb-item">Books</div>
                    <div class="breadcrumb-item">Edit</div>
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
                                <form action="{{ route('admin.update.book', $book->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Category</label>
                                            <select class="form-control selectric" tabindex="1" id="category"
                                                name="category" value="{{ $book->category_id }} {{ old('category') }}">
                                                @foreach ($category as $cate)
                                                    <option value="{{ $cate->id }}"
                                                        {{ $cate->id == $book->category_id ? 'selected' : '' }}>
                                                        {{ $cate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Title</label>
                                            <input type="text" tabindex="2" class="form-control" id="title"
                                                name="title" value="{{ $book->title }} {{ old('title') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Abstract</label>
                                            <textarea class="summernote" tabindex="3" id="abstract" name="abstract"
                                                value="{{ $book->abstract }} {{ old('abstract') }}">{{ $book->abstract }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Fill</label>
                                            <textarea class="summernote" tabindex="4" id="fill" name="fill"
                                                value="{{ $book->fill }} {{ old('fill') }}">{{ $book->fill }}</textarea>
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
