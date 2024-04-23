@extends('layouts.app')

@section('title', 'Katalog')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Katalog</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="/admin/katalog/create"
                                    class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Create Katalog
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
                                            <th>ID</th>
                                            <th>Book Title</th>
                                            <th>Writer</th>
                                            <th>Last Uploaded</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>2017-01-09</td>
                                            <td><a href="#"
                                                    class="btn btn-secondary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>2017-01-09</td>
                                            <td><a href="#"
                                                    class="btn btn-secondary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>2017-01-09</td>
                                            <td><a href="#"
                                                    class="btn btn-secondary">Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>2017-01-09</td>
                                            <td><a href="#"
                                                    class="btn btn-secondary">Detail</a></td>
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

    <!-- Page Specific JS File -->
@endpush
