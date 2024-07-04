@extends('layouts.app-author')

@section('title', 'Books')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
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
                                <h4></h4>
                                <div class="card-header-action">
                                    <form action="{{ route('author.index.book') }}" method="GET">
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
                                    <table class="table-striped table" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Book Title</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($books as $key => $book)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $book->title }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($book->created_at)->translatedFormat('l, d F Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($book->status->option == 'Reviewing')
                                                            <span
                                                                class="badge badge-primary">{{ $book->status->option }}</span>
                                                        @elseif($book->status->option == 'Approve')
                                                            <span
                                                                class="badge badge-success">{{ $book->status->option }}</span>
                                                        @elseif($book->status->option == 'Rejected')
                                                            <span
                                                                class="badge badge-danger">{{ $book->status->option }}</span>
                                                        @elseif($book->status->option == 'Pending')
                                                            <span
                                                                class="badge badge-warning">{{ $book->status->option }}</span>                                                        
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($book->status->option == 'Pending')
                                                            <form action="{{ route('author.submit.book', $book->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button class="btn btn-success mr-1" type="submit">
                                                                    <i class="fas fa-check"></i> Submit
                                                                </button>
                                                            </form>
                                                        @else
                                                            <div class="none"></div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <nav aria-label="...">
                                    <ul class="pagination justify-content-center">
                                        @if ($books->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $books->previousPageUrl() }}"
                                                    tabindex="-1">Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                                            <li class="page-item {{ $page == $books->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        @if ($books->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $books->nextPageUrl() }}">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next</span>
                                            </li>
                                        @endif
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
