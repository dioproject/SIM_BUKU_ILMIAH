@extends('layouts.app-admin')

@section('title', 'Book Data')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Categories</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Categories</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('admin.create.book') }}" class="btn btn-icon icon-left btn-primary"><i
                                        class="far fa-edit"></i> Create category
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
                                            <th>Name</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($category as $key => $cate)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $cate->name }}</td>
                                                <td>{{ $cate->created_at }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                        title="Edit" href="{{ route('admin.edit.category', $category->id) }}"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                    <form action="{{ route('admin.destroy.category', $category->id) }}"
                                                        method="POST" class="btn btn-danger p-0" type="button"
                                                        onsubmit="return confirm('Are you sure want to delete it?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" id="swal-6" data-toggle="tooltip"
                                                            title="Delete"><i class="fas fa-trash"></i></button>
                                                    </form>
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
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush