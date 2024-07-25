@extends('layouts.app-author')

@section('title', 'Chapters')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Chapters</h1>
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
                                    <form action="{{ route('author.index.chapter') }}" method="GET">
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
                                                <th>Book Title</th>
                                                <th>Author</th>
                                                <th>Chapter</th>
                                                <th>Submited At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($chapters as $key => $chapter)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $chapter->book->title }}</td>
                                                    <td>{{ $chapter->fileChapter->user->username ?? '' }}</td>
                                                    <td>{{ $chapter->chapter }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($chapter->created_at)->translatedFormat('l, d F Y') }}</td>
                                                    <td>
                                                        @if ($chapter->status->option == 'Revisi')
                                                            <span
                                                                class="badge badge-warning">{{ $chapter->status->option }}</span>
                                                        @elseif($chapter->status->option == 'Approve')
                                                            <span
                                                                class="badge badge-success">{{ $chapter->status->option }}</span>
                                                        @elseif($chapter->status->option == 'Reject')
                                                            <span
                                                                class="badge badge-danger">{{ $chapter->status->option }}</span>
                                                        @elseif($chapter->status->option == 'Submit')
                                                            <span
                                                                class="badge badge-warning">{{ $chapter->status->option }}</span>
                                                        @elseif($chapter->status->option == 'Pending')
                                                            <span
                                                                class="badge badge-secondary">{{ $chapter->status->option }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-success btn-action mr-1" title="Detail"
                                                            href="{{ route('author.show.chapter', $chapter->id) }}"
                                                            data-toggle="tooltip">
                                                            <i class="fas fa-list"></i>
                                                        </a>
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
                                        @if ($chapters->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $chapters->previousPageUrl() }}"
                                                    tabindex="-1">Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($chapters->getUrlRange(1, $chapters->lastPage()) as $page => $url)
                                            <li class="page-item {{ $page == $chapters->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        @if ($chapters->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $chapters->nextPageUrl() }}">Next</a>
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
