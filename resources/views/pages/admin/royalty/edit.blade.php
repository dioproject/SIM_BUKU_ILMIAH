@extends('layouts.app-admin')

@section('title', 'Edit Royalty')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Royalty</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Royalty</div>
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
                                <form id="create-user-form" action="{{ route('admin.update.royalty', $royalty->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Author</label>
                                            <select class="form-control select2" tabindex="1" id="author_id"
                                                name="author_id" value="{{ $royalty->author_id }} {{ old('author_id') }}">
                                                @foreach ($manuscripts as $manuscript)
                                                    <option value="{{ $manuscript->author_id }}"
                                                        {{ $royalty->book_id == $manuscript->id ? 'selected' : '' }}>
                                                        {{ $manuscript->author->first_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Book Title</label>
                                            <select class="form-control select2" tabindex="2" id="book_id"
                                                name="book_id" value="{{ $royalty->book_id }} {{ old('book_id') }}">
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}"
                                                        {{ $royalty->book_id == $book->id ? 'selected' : '' }}>
                                                        {{ $book->manuscript->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Royalty</label>
                                            <input type="text" tabindex="3" class="form-control" id="amount"
                                                name="amount" value="{{ $royalty->amount }} {{ old('amount') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Status</label>
                                            <select class="form-control select2" tabindex="4" id="status_id"
                                                name="status_id" value="{{ $royalty->status_id }} {{ old('status_id') }}">
                                                @foreach ($status as $stat)
                                                    <option value="{{ $stat->id }}"
                                                        {{ $royalty->status_id == $stat->id ? 'selected' : '' }}>
                                                        {{ $stat->option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label">Proof of Payment</label>
                                            <div class="form-control custom-file">
                                                <input type="file" tabindex="5" name="path_foto" class="custom-file-input"
                                                    id="path_foto" value="{{ $royalty->path_foto }} {{ old('path_foto') }}" accept="image/*">
                                                <label class="custom-file-label">Choose File</label>
                                            </div>
                                            <div class="form-text text-muted">The image must have a maximum size of 1MB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <button type="submit" class="btn btn-primary">Create</button>
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
@endpush
