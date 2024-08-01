@extends('layouts.app-admin')

@section('title', 'Data Naskah')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Naskah</h1>
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
                                        class="far fa-edit"></i> Tambar Buku
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
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Judul Buku</th>
                                                <th>Tahun</th>
                                                <th>Total Bab</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($books as $key => $book)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $book->judul }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($book->created_at)->translatedFormat('Y') }}</td>
                                                    <td>{{ $book->total_bab }}</td>
                                                    <td>
                                                        <a class="btn btn-success btn-action mr-1" data-toggle="tooltip"
                                                            title="Detail"
                                                            href="{{ route('admin.show.book', $book->id) }}"><i
                                                                class="fas fa-list"></i>
                                                        </a>
                                                        <a class="btn btn-secondary btn-action mr-1"
                                                            title="Download" href="{{ route('admin.merge.book', $book->id) }}"
                                                            data-toggle="tooltip">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <form action="{{ route('admin.destroy.book', $book->id) }}"
                                                            method="POST" class="btn btn-danger p-0" type="button">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-action delete-button"
                                                                title="Delete"><i class="fas fa-trash"></i></button>
                                                        </form>
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
@endpush
