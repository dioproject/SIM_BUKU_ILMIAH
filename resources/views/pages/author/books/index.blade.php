@extends('layouts.app-author')

@section('title', 'Data Naskah')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-book"></i> Data Naskah</h1>
            </div>
            <div class="section-body">
                <x-flash-message />

                <x-admin.card title="Daftar Buku" icon="list">
                    <x-slot name="action">
                        <form action="{{ route('author.index.book') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari..." name="search"
                                    value="{{ request('search') }}">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </x-slot>

                    <x-admin.table :headers="['No.', 'Judul Buku', 'Template', 'Total Bab', 'Aksi']">
                        @foreach ($books as $key => $book)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $book->judul ?? '' }}</td>
                                <td>
                                    <a href="{{ Storage::url('upload/books/' . $book->template) }}" download="{{ $book->template }}">{{ $book->template }}</a>
                                </td>
                                <td>{{ $book->total_bab ?? '' }}</td>
                                <td>
                                    <a class="btn btn-success btn-action {{ $book->filledChaptersCount == 0 ? 'disabled' : '' }}"
                                        title="Detail" href="{{ route('author.show.book', $book->id) }}"
                                        data-toggle="tooltip">
                                        <i class="fas fa-list"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </x-admin.table>

                    <x-admin.pagination :paginator="$books" />
                </x-admin.card>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush
