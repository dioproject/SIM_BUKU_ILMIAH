@extends('layouts.app-reviewer')

@section('title', 'Ulasan')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-star"></i> Ulasan</h1>
        </div>
        <div class="section-body">
            <x-flash-message />

            <div class="row">
                <div class="col-12">
                    <x-admin.card>
                        <div class="card-header">
                            <a href="{{ route('editor.create.review') }}" class="btn btn-icon icon-left btn-primary">
                                <i class="far fa-comment"></i> Buat Ulasan
                            </a>
                            <h4></h4>
                            <div class="card-header-action">
                                <form action="{{ route('editor.index.review') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" placeholder="Cari..."
                                            value="{{ request()->query('search') }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <x-admin.table :headers="['No', 'Judul Bab', 'Penulis', 'Ulasan', 'Terakhir Diubah', 'Aksi']">
                                @foreach ($reviews as $key => $rev)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $rev->bab->buku->judul ?? ($rev->bab->nama ?? 'Buku tidak ditemukan.') }}</td>
                                        <td>{{ $rev->bab->author->name ?? ($rev->bab->author->username ?? 'Pengguna tidak ditemukan.') }}</td>
                                        <td>{{ $rev->content }}</td>
                                        <td>{{ $rev->updated_at }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                title="Edit" href="{{ route('editor.edit.review', $rev->id) }}"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <form action="{{ route('editor.destroy.review', $rev->id) }}"
                                                method="POST" class="btn btn-danger p-0" type="button">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-action delete-button"
                                                    title="Hapus"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-admin.table>
                        </div>

                        <x-admin.pagination :paginator="$reviews" />
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
