@extends('layouts.app-admin')

@section('title', 'Categories')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Category</h1>
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
                                <a href="{{ route('admin.create.category') }}" class="btn btn-icon icon-left btn-primary"><i
                                        class="far fa-edit"></i> Create category
                                </a>
                                <h4></h4>
                            <div class="card-header-action">
                                <form action="{{ route('admin.index.category') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->query('search') }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
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
                                            <th>Name</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($category as $key => $cate)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $cate->name }}</td>
                                                <td>{{ $cate->created_at }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                        title="Edit" href="{{ route('admin.edit.category', $cate->id) }}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    <form action="{{ route('admin.destroy.category', $cate->id) }}"
                                                        method="POST" class="btn btn-danger p-0" type="button">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-action delete-button"
                                                            title="Delete"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                        <nav aria-label="...">
                            <ul class="pagination justify-content-center">
                                @if ($category->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $category->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                @foreach ($category->getUrlRange(1, $category->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $category->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($category->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $category->nextPageUrl() }}">Next</a>
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
