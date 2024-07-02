@extends('layouts.app-author')

@section('title', 'Edit Book')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Book</h1>
                <div class="section-header-breadcrumb">
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
                                <form action="{{ route('author.update.book', $book->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Category
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select class="form-control selectric" tabindex="1" id="category"
                                                name="category" value="{{ $book->category_id }} {{ old('category') }}">
                                                @foreach ($category as $cate)
                                                    <option value="{{ $cate->id }}"
                                                        {{ $cate->id == $book->category_id ? 'selected' : '' }}>
                                                        {{ $cate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Title :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" tabindex="2" class="form-control" id="title"
                                                name="title" value="{{ $book->title }} {{ old('title') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Script
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="file" tabindex="3" class="form-control" id="script"
                                                name="script" value="{{ $book->script }} {{ old('script') }}"
                                                accept=".doc,.docx">
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Document Collection</h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>File Name</th>
                                                <th>Information</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1.</td>
                                                <td><a href="{{ Storage::url('upload/books/') . $book->script }}"
                                                        download="{{ $book->script }}">{{ $book->script }}</a></td>
                                                <td>Script</a></td>
                                                <td>
                                                    @if ($book->status->option == 'REVIEWING')
                                                        <span
                                                            class="badge badge-primary">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'APPROVE')
                                                        <span
                                                            class="badge badge-success">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'REJECTED')
                                                        <span class="badge badge-danger">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'PENDING')
                                                        <span
                                                            class="badge badge-warning">{{ $book->status->option }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-secondary">{{ $book->status->option }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2.</td>
                                                <td><a href="{{ Storage::url('upload/books/') . $book->template }}"
                                                        download="{{ $book->template }}">{{ $book->template }}</a></td>
                                                <td>Template</td>
                                                <td>
                                                    @if ($book->status->option == 'REVIEWING')
                                                        <span
                                                            class="badge badge-primary">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'APPROVE')
                                                        <span
                                                            class="badge badge-success">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'REJECTED')
                                                        <span class="badge badge-danger">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'PENDING')
                                                        <span
                                                            class="badge badge-warning">{{ $book->status->option }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-secondary">{{ $book->status->option }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
