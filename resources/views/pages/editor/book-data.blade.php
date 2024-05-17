@extends('layouts.app-editor')

@section('title', 'Book Data')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Book Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Data</div>
                    <div class="breadcrumb-item"><a href="/editor/bookdata">Book Data</a></div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="/editor/bookdata/review"
                                    class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Review Book
                                </a>
                                <h4></h4>
                                <div class="card-header-action">
                                    <form>
                                        <div class="input-group">
                                            <input type="text"
                                                class="form-control"
                                                placeholder="Search">
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
                                            <th>Book Code</th>
                                            <th>Book Title</th>
                                            <th>Writer</th>
                                            <th>Last Modified</th>
                                            <th>Comment</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>2017-01-09</td>
                                            <td>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-action mr-1"
                                                    data-toggle="tooltip"
                                                    title="Edit" href="/admin/bookdata/edit"><i class="fas fa-pencil-alt"></i></a>
                                                <a class="btn btn-danger"
                                                    data-toggle="tooltip"
                                                    title="Delete"
                                                    id="swal-6"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>2017-01-09</td>
                                            <td>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-action mr-1"
                                                    data-toggle="tooltip"
                                                    title="Edit" href="/admin/bookdata/edit"><i class="fas fa-pencil-alt"></i></a>
                                                <a class="btn btn-danger"
                                                    data-toggle="tooltip"
                                                    title="Delete"
                                                    id="swal-6"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>2017-01-09</td>
                                            <td>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-action mr-1"
                                                    data-toggle="tooltip"
                                                    title="Edit" href="/admin/bookdata/edit"><i class="fas fa-pencil-alt"></i></a>
                                                <a class="btn btn-danger"
                                                    data-toggle="tooltip"
                                                    title="Delete"
                                                    id="swal-6"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>2017-01-09</td>
                                            <td>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-action mr-1"
                                                    data-toggle="tooltip"
                                                    title="Edit" href="/admin/bookdata/edit"><i class="fas fa-pencil-alt"></i></a>
                                                <a class="btn btn-danger"
                                                    data-toggle="tooltip"
                                                    title="Delete"
                                                    id="swal-6"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    <ul class="pagination mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link"
                                                href="#"
                                                tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                        </li>
                                        <li class="page-item active"><a class="page-link"
                                                href="#">1 <span class="sr-only">(current)</span></a></li>
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="#">2</a>
                                        </li>
                                        <li class="page-item"><a class="page-link"
                                                href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="#"><i class="fas fa-chevron-right"></i></a>
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
