@extends('layouts.app-admin')

@section('title', 'Katalog')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Katalog</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4></h4>
                                <div class="card-header-action">
                                    <form method="GET" action="{{ route('admin.index.catalog') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search"
                                                value="{{ $search ?? '' }}" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary"><i
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
                                                <th>Penulis</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($catalogs as $key => $catalog)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $catalog->final->buku->judul }}</td>
                                                    <td>{{ $catalog->final->buku->bab->first()->author->username ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <nav aria-label="...">
                                    <ul class="pagination justify-content-center">
                                        @if ($catalogs->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $catalogs->previousPageUrl() }}"
                                                    tabindex="-1">Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($catalogs->getUrlRange(1, $catalogs->lastPage()) as $page => $url)
                                            <li class="page-item {{ $page == $catalogs->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        @if ($catalogs->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $catalogs->nextPageUrl() }}">Next</a>
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
