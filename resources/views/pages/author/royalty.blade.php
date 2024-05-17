@extends('layouts.app-author')

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
                                <a href="/admin/royalty/create"
                                    class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i> Create Royalty
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
                                            <th>Book Title</th>
                                            <th>Writer</th>
                                            <th>Price</th>
                                            <th>Sold</th>
                                            <th>Royalty</th>
                                            <th>Status</th>
                                        </tr>
                                        <tr>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>98237</td>
                                            <td>17</td>
                                            <td>15000</td>
                                            <td>
                                                <div class="badge badge-success">Success</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>201700</td>
                                            <td>17</td>
                                            <td>15000</td>
                                            <td>
                                                <div class="badge badge-success">Success</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>12378</td>
                                            <td>17</td>
                                            <td>15000</td>
                                            <td>
                                                <div class="badge badge-success">Success</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Irwansyah Saputra</td>
                                            <td>Lorem</td>
                                            <td>170109</td>
                                            <td>17</td>
                                            <td>15000</td>
                                            <td>
                                                <div class="badge badge-success">Success</div>
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

    <!-- Page Specific JS File -->
@endpush
