@extends('layouts.app-editor')

@section('title', 'Book Detail')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Book Detail</h1>
            </div>
            <div class="section-body">
                @if ($book->status->option == 'APPROVE')
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Review Book</h4>
                                </div>
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
                                    <form id="create-review-form" action="{{ route('editor.review.book', $book->id) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Review
                                                :</label>
                                            <div class="col-sm-12 col-md-10">
                                                <input type="file" tabindex="1" class="form-control" id="review"
                                                    name="review" value="{{ old('review') }}" accept=".doc,.docx">
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
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Book Title</th>
                                                <th>File Name</th>
                                                <th>Information</th>
                                                <th>Status</th>
                                                @if ($book->status->option == 'PENDING')
                                                    <th>Action</th>
                                                @else
                                                    <th class="none"></th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1.</td>
                                                <td>{{ $book->title }}</td>
                                                <td><a href="{{ Storage::url('upload/books/') . $book->script }}"
                                                        download="{{ $book->script }}">{{ $book->script }}</a></td>
                                                <td>Script</td>
                                                <td>
                                                    @if ($book->status->option == 'REVIEWING')
                                                        <span class="badge badge-primary">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'APPROVE')
                                                        <span class="badge badge-success">{{ $book->status->option }}</span>
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
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @if ($book->status->option == 'PENDING')
                                                            <form action="{{ route('editor.approve.book', $book->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button class="btn btn-success mr-1" type="submit">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('editor.rejected.book', $book->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button class="btn btn-danger mr-1" type="submit">
                                                                    <i class="fas fa-ban"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <div class="none"></div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2.</td>
                                                <td>{{ $book->title }}</td>
                                                <td><a href="{{ Storage::url('upload/books/') . $book->template }}"
                                                        download="{{ $book->template }}">{{ $book->template }}</a></td>
                                                <td>Template</td>
                                            </tr>
                                            @if ($book->review !== null)
                                                <tr>
                                                    <td class="text-center">3.</td>
                                                    <td>{{ $book->title }}</td>
                                                    <td><a href="{{ Storage::url('upload/books/') . $book->review }}"
                                                            download="{{ $book->review }}">{{ $book->review }}</a></td>
                                                    <td>Review</td>
                                                </tr>
                                            @endif
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
