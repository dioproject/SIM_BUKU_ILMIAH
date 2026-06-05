@extends('layouts.app-admin')

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
                            <h4>Semua Bab</h4>
                            <div class="card-header-action">
                                <form action="{{ route('admin.index.chapter') }}" method="GET">
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
                            <x-admin.table :headers="['No', 'Judul Buku', 'Penulis', 'Pereview', 'Bab', 'Tanggal Dibuat', 'Status']">
                                @foreach ($chapters as $key => $chapter)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.show.book', $chapter->buku->id) }}">
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
                                        <td>
                                            @if($chapter->reviewer)
                                                <span class="badge badge-light">
                                                    <i class="fas fa-user-check"></i> {{ $chapter->reviewer->username }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $chapter->nama }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($chapter->created_at)->translatedFormat('j F Y') }}</td>
                                        <td>
                                            <x-status-badge :status="$chapter->status" />
                                        </td>
                                    </tr>
                                @endforeach
                            </x-admin.table>
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
