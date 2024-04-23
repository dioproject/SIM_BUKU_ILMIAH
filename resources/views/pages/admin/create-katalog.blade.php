@extends('layouts.app')

@section('title', 'Create Katalog')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Katalog</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin/katalog">Katalog</a></div>
                    <div class="breadcrumb-item"><a href="/admin/katalog/create">Create</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Title</label>
                                        <select class="form-control selectric">
                                            <option>Islam</option>
                                            <option>Hindu</option>
                                            <option>Budha</option>
                                            <option>Konghucu</option>
                                            <option>Kristen</option>
                                            <option>Katolik</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label">Photos</label>
                                        <div class="form-control custom-file">
                                            <input type="file"
                                                name="site_logo"
                                                class="custom-file-input"
                                                id="site-logo">
                                            <label class="custom-file-label">Choose File</label>
                                        </div>
                                        <div class="form-text text-muted">The image must have a maximum size of 1MB
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Caption</label>
                                    <textarea class="form-control"
                                        data-height="150"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit"
                                    class="btn btn-primary">Submit</button>
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
