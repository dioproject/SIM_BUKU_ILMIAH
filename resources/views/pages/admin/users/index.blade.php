@extends('layouts.app-admin')

@section('title', 'Pengguna')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-users"></i> Pengguna</h1>
            </div>
            <div class="section-body">
                <x-flash-message />
                <div class="row">
                    <div class="col-12">
                        @php
                            $action = '<div class="d-flex align-items-center flex-wrap justify-content-between w-100">
                                <a href="' . route('admin.create.user') . '" class="btn btn-icon icon-left btn-primary mb-2"><i class="fas fa-user-plus"></i> Tambah Pengguna</a>
                                <form action="' . route('admin.index.user') . '" method="GET" class="mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" placeholder="Cari..." value="' . request()->query('search') . '">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>';
                        @endphp
                        <x-admin.card :action="$action">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Peran</th>
                                            <th>Dibuat Pada</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->user_role }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                        title="Edit"
                                                        href="{{ route('admin.edit.user', $user->id) }}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    <form action="{{ route('admin.destroy.user', $user->id) }}"
                                                        method="POST" class="btn btn-danger p-0" type="button">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-action delete-button"
                                                            title="Hapus"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <nav aria-label="...">
                                    <ul class="pagination justify-content-center">
                                        @if ($users->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Sebelumnya</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->previousPageUrl() }}"
                                                    tabindex="-1">Sebelumnya</a>
                                            </li>
                                        @endif

                                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                            <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        @if ($users->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->nextPageUrl() }}">Selanjutnya</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Selanjutnya</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
