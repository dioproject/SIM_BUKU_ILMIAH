@extends('layouts.app-admin')

@section('title', 'Royalti')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Royalti</h1>
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
                            <a href="{{ route('admin.create.royalty') }}" class="btn btn-icon icon-left btn-primary"><i
                                    class="far fa-edit"></i> Tambah Royalti
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Judul Buku</th>
                                            <th>Author</th>
                                            <th>Bab</th>
                                            <th>Penerbitan</th>
                                            <th>Persentase</th>
                                            <th>Royalti/Bab</th>
                                            <th>Total Royalti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($royalties as $key => $royalti)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $royalti->penerbitan->final->buku->judul ?? '' }}</td>
                                                <td>{{ $royalti->user->username ?? '' }}</td>
                                                <td>{{ $royalti->bab->nama ?? '' }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($royalti->created_at)->translatedFormat('F Y') }}
                                                </td>
                                                <td>{{ $royalti->persentase }} %</td>
                                                <td>Rp. {{ number_format($royalti->royalti_bab, 0, ',', '.') }}</td>
                                                <td>Rp. {{ number_format($royalti->total_royalti, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            <nav aria-label="...">
                                <ul class="pagination justify-content-center">
                                    @if ($royalties->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $royalties->previousPageUrl() }}"
                                                tabindex="-1">Previous</a>
                                        </li>
                                    @endif

                                    @foreach ($royalties->getUrlRange(1, $royalties->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $royalties->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($royalties->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $royalties->nextPageUrl() }}">Next</a>
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
    <!-- JS Libraries -->

    <!-- Page Specific JS File -->
@endpush
