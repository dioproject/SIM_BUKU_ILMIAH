@extends('layouts.app-admin')

@section('title', 'Books')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Books</h1>
            </div>
            <div class="section-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ session('success') }}.
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ session('error') }}.
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('admin.create.book') }}" class="btn btn-icon icon-left btn-primary"><i
                                        class="far fa-edit"></i> Create Book
                                </a>
                                <h4></h4>
                                <div class="card-header-action">
                                    <form action="{{ route('admin.index.book') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="search"
                                                value="{{ request('search') }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-bordered table-md table">
                                        <tr>
                                            <th>No.</th>
                                            <th>Book Title</th>
                                            <th>Author</th>
                                            <th>Last Modified</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($books as $key => $book)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $title[$key]->title }}</td>
                                                @foreach ($author as $aut)
                                                    <td>{{ $aut->first_name }}</td>
                                                @endforeach
                                                <td>{{ $book->updated_at }}</td>
                                                <td>{{ $status[$key]->option }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                        title="Edit" href="{{ route('admin.edit.book', $book->id) }}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    <form action="{{ route('admin.destroy.book', $book->id) }}"
                                                        method="POST" class="btn btn-danger p-0 mr-1" type="button">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-action delete-button"
                                                            title="Delete"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                    <a class="btn btn-primary btn-action" data-toggle="tooltip"
                                                        title="Review" href="{{ route('admin.edit.review', $book->id) }}"><i
                                                            class="fas fa-comment"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    <ul class="pagination mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1"><i
                                                    class="fas fa-chevron-left"></i></a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1<span
                                                    class="sr-only">(current)</span></a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush
