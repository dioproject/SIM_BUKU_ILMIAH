@extends('layouts.app-admin')

@section('title', 'Royalty')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Royalty</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('admin.create.royalty') }}" class="btn btn-icon icon-left btn-primary"><i
                                        class="far fa-edit"></i> Create Royalty
                                </a>
                                <h4></h4>
                            <div class="card-header-action">
                                <form method="GET" action="{{ route('admin.index.royalty') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" value="{{ $search ?? '' }}" placeholder="Search">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
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
                                        <th>Royalty</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($royalty as $key => $royal)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $royal->book->manuscript->title }}</td>
                                            <td>{{ $royal->book->manuscript->author->first_name }}</td>
                                            <td>{{ $royal->amount }}</td>
                                            <td>{{ $royal->status->option }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                    title="Edit"
                                                    href="{{ route('admin.edit.royalty', $royal->id) }}"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                            <div class="card-footer">
                        <nav aria-label="...">
                            <ul class="pagination justify-content-center">
                                @if ($royalty->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $royalty->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                @foreach ($royalty->getUrlRange(1, $royalty->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $royalty->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($royalty->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $royalty->nextPageUrl() }}">Next</a>
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
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
