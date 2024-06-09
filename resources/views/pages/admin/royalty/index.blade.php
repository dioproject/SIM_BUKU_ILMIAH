@extends('layouts.app-admin')

@section('title', 'Royalty')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Royalty</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('admin.create.royalty') }}" class="btn btn-icon icon-left btn-primary"><i
                                        class="far fa-edit"></i> Create Royalty
                                </a>
                                <h4></h4>
                                <div class="card-header-action">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-bordered table-md table">
                                        <tr>
                                            <th>No.</th>
                                            <th>Book Title</th>
                                            <th>Author</th>
                                            <th>Royalty</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($royalty as $key => $royal)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $royal->book->manuscript->title }}</td>
                                                <td>{{ $royal->book->manuscript->author->first_name }}</td>
                                                <td>{{ $royal->amount }}</td>
                                                <td>{{ $royal->status->option }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                        title="Edit"
                                                        href="{{ route('admin.edit.royalty', $royal->id) }}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    {{-- <form action="{{ route('admin.destroy.royalty', $royal->id) }}"
                                                        method="POST" class="btn btn-danger p-0" type="button"
                                                        onsubmit="return confirm('Are you sure want to delete it?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" id="swal-6" data-toggle="tooltip"
                                                            title="Delete"><i class="fas fa-trash"></i></button>
                                                    </form> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    <ul class="pagination mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1"><i
                                                    class="fas fa-chevron-left"></i></a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1 <span
                                                    class="sr-only">(current)</span></a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                        </li>
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
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
