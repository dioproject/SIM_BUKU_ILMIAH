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
                                <form id="create-user-form" action="{{ route('admin.store.royalty') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Author</label>
                                            <select class="form-control select2" tabindex="1" id="author_id"
                                                name="author_id" value="{{ old('author_id') }}">
                                                @foreach ($manuscripts as $manuscript)
                                                    <option value="{{ $manuscript->author_id }}"
                                                        @if (old('author_id') == $manuscript->author_id) selected @endif>
                                                        {{ $manuscript->author->first_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Book</label>
                                            <select class="form-control select2" tabindex="2" id="book_id"
                                                name="book_id" value="{{ old('book_id') }}">
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}"
                                                        @if (old('book_id') == $book->id) selected @endif>
                                                        {{ $book->manuscript->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Royalty</label>
                                            <input type="text" tabindex="3" class="form-control" id="amount"
                                                name="amount" value="{{ old('amount') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Book</label>
                                            <select class="form-control select2" tabindex="4" id="status_id"
                                                name="status_id" value="{{ old('status_id') }}">
                                                @foreach ($status as $stat)
                                                    <option value="{{ $stat->id }}"
                                                        @if (old('status-id') == $stat->id) selected @endif>
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
                                                    id="path_foto" value="{{ old('path_foto') }}" accept="image/*">
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
