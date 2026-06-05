@extends('layouts.app-reviewer')

@section('title', 'Buku')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-book"></i> Buku</h1>
            </div>
            <div class="section-body">
                <x-flash-message />

                <x-admin.card title="Daftar Buku" icon="list">
                    <x-slot name="action">
                        <form action="{{ route('reviewer.index.book') }}" method="GET">
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

                    <x-admin.table :headers="['No.', 'Judul Buku', 'Total Bab', 'Aksi']">
                        @foreach ($books as $key => $book)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $book->judul ?? '' }}</td>
                                <td>{{ $book->total_bab ?? '' }}</td>
                                <td>
                                    <a class="btn btn-success btn-action mr-1 {{ $book->filledChaptersCount == 0 ? 'disabled' : '' }}"
                                        title="Detail" href="{{ route('reviewer.show.book', $book->id) }}"
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
