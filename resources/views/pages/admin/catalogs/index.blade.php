@extends('layouts.app-admin')

@section('title', 'Catalogs')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Catalogs</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12"> 
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('admin.create.catalog') }}"
                                    class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Create Catalog
                                </a>
                                <h4></h4>
                            <div class="card-header-action">
                                <form method="GET" action="{{ route('admin.index.catalog') }}">
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
                                        <th>Last Uploaded</th>
                                    </tr>
                                    @foreach ($catalog as $key => $cata)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $cata->book->manuscript->title }}</td>
                                            <td>{{ $cata->book->manuscript->author->first_name }}</td>
                                            <td>{{ $cata->updated_at }}</td>
                                            </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                        <nav aria-label="...">
                            <ul class="pagination justify-content-center">
                                @if ($catalog->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $catalog->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                @foreach ($catalog->getUrlRange(1, $catalog->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $catalog->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($catalog->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $catalog->nextPageUrl() }}">Next</a>
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
