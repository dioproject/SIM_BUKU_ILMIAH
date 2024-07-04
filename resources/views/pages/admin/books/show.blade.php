@extends('layouts.app-admin')

@section('title', 'Book Detail')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
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
                                                <th>Submission Author</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1.</td>
                                                <td>{{ $book->title }}</td>
                                                <td>{{ $book->user->first_name }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @if ($book->status->option == 'Submit')
                                                            <form action="{{ route('admin.accept.book', $book->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button class="btn btn-success mr-1" type="submit">
                                                                    <i class="fas fa-check"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('admin.reject.book', $book->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button class="btn btn-danger mr-1" type="submit">
                                                                    <i class="fas fa-ban"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <div class="none"></div>
                                                        @endif
                                                    </div>
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
