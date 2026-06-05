@extends('layouts.app-reviewer')

@section('title', 'Daftar Bab')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-book-open"></i> Daftar Bab</h1>
        </div>
        <div class="section-body">
            <x-flash-message />
            
            <div class="row">
                <div class="col-12">
                    <x-admin.card>
                        <div class="card-header">
                            <h4>Bab yang Ditugaskan</h4>
                            <div class="card-header-action">
                                <form action="{{ route('reviewer.index.chapter') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari bab..." name="search"
                                            value="{{ request('search') }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($chapters->count() > 0)
                                <x-admin.table :headers="['No', 'Judul Buku', 'Penulis', 'Bab', 'Tanggal Dibuat', 'Status', 'Aksi']">
                                    @foreach ($chapters as $key => $chapter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a href="{{ route('reviewer.show.book', $chapter->buku->id) }}">
                                                    {{ $chapter->buku->judul }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($chapter->author)
                                                    <span class="badge badge-light">
                                                        <i class="fas fa-user"></i> {{ $chapter->author->username }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td><strong>{{ $chapter->nama }}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($chapter->created_at)->translatedFormat('l, d F Y') }}</td>
                                            <td>
                                                @if ($chapter->file_bab)
                                                    <x-status-badge :status="$chapter->status" />
                                                @else
                                                    <span class="badge badge-secondary">
                                                        <i class="fas fa-clock"></i> Menunggu Naskah
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-sm" data-toggle="tooltip" title="Detail"
                                                    href="{{ route('reviewer.show.chapter', $chapter->id) }}">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-admin.table>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada bab</h5>
                                    <p class="text-muted">Anda belum ditugaskan untuk me-review bab apapun.</p>
                                </div>
                            @endif
                        </div>
                        
                        <x-admin.pagination :paginator="$chapters" />
                    </x-admin.card>
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
