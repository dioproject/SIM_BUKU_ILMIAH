@extends('layouts.app-admin')

@section('title', 'Data Buku')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
        .book-card {
            transition: all 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
    </style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-book"></i> Data Buku</h1>
        </div>
        <div class="section-body">
            <x-flash-message />
            
            <div class="row">
                <div class="col-12">
                    <x-admin.card>
                        <div class="card-header">
                            <a href="{{ route('admin.create.book') }}" class="btn btn-icon icon-left btn-primary">
                                <i class="far fa-edit"></i> Tambah Buku
                            </a>
                            <div class="card-header-action">
                                <form action="{{ route('admin.index.book') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari buku..." name="search"
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
                            @if($books->count() > 0)
                                <x-admin.table :headers="['No', 'Judul Buku', 'Tahun', 'Total Bab', 'Aksi']">
                                    @foreach ($books as $key => $book)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <strong>{{ $book->judul }}</strong>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($book->created_at)->translatedFormat('F Y') }}</td>
                                            <td>
                                                <span class="badge badge-primary">{{ $book->total_bab }} bab</span>
                                            </td>
                                            <td>
                                                <a class="btn btn-success btn-sm mr-1" data-toggle="tooltip" title="Detail"
                                                    href="{{ route('admin.show.book', $book->id) }}">
                                                    <i class="fas fa-list"></i>
                                                </a>
                                                <form action="{{ route('admin.merge.bab', $book->id) }}" method="POST" class="btn btn-primary btn-sm p-0 mr-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm" title="Gabungkan Bab">
                                                        <i class="fas fa-object-group"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.destroy.book', $book->id) }}" method="POST" class="btn btn-danger btn-sm p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm delete-button" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-admin.table>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada buku</h5>
                                    <p class="text-muted">Klik tombol "Tambah Buku" untuk membuat buku baru.</p>
                                    <a href="{{ route('admin.create.book') }}" class="btn btn-primary">
                                        <i class="far fa-edit"></i> Tambah Buku
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <x-admin.pagination :paginator="$books" />
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
