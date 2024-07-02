@extends('layouts.app-admin')

@section('title', 'Book Detail')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Book Detail</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-2">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Book Title</th>
                                                <th>File Name</th>
                                                <th>Information</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1.</td>
                                                <td>{{ $book->title }}</td>
                                                <td><a href="{{ Storage::url('upload/books/') . $book->script }}"
                                                        download="{{ $book->script }}">{{ $book->script }}</a></td>
                                                <td>Script</td>
                                                <td>
                                                    @if ($book->status->option == 'REVIEWING')
                                                        <span class="badge badge-primary">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'APPROVE')
                                                        <span class="badge badge-success">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'REJECTED')
                                                        <span class="badge badge-danger">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'PENDING')
                                                        <span class="badge badge-warning">{{ $book->status->option }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-secondary">{{ $book->status->option }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2.</td>
                                                <td>{{ $book->title }}</td>
                                                <td><a href="{{ Storage::url('upload/books/') . $book->template }}"
                                                        download="{{ $book->template }}">{{ $book->template }}</a></td>
                                                <td>Template</td>
                                                <td>
                                                    @if ($book->status->option == 'REVIEWING')
                                                        <span
                                                            class="badge badge-primary">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'APPROVE')
                                                        <span
                                                            class="badge badge-success">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'REJECTED')
                                                        <span class="badge badge-danger">{{ $book->status->option }}</span>
                                                    @elseif($book->status->option == 'PENDING')
                                                        <span
                                                            class="badge badge-warning">{{ $book->status->option }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-secondary">{{ $book->status->option }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
