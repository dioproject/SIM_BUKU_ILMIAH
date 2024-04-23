@extends('layouts.app')

@section('title', 'Create User')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Data</a></div>
                    <div class="breadcrumb-item"><a href="#">User Data</a></div>
                    <div class="breadcrumb-item"><a href="#">Create</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>First Name</label>
                                        <input type="text"
                                            class="form-control"
                                            id="first-name"
                                            name="first-name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Long Name</label>
                                        <input type="text"
                                            class="form-control"
                                            id="long-name"
                                            name="long-name">
                                    </div>                                
                                    <div class="form-group col-md-4">
                                        <label>Email</label>
                                        <input type="email"
                                            class="form-control"
                                            id="email"
                                            name="email">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Password</label>
                                        <input type="password"
                                            class="form-control"
                                            id="password"
                                            name="password">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Religion</label>
                                        <select class="form-control selectric">
                                            <option>Islam</option>
                                            <option>Hindu</option>
                                            <option>Budha</option>
                                            <option>Konghucu</option>
                                            <option>Kristen</option>
                                            <option>Katolik</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Place of Birth</label>
                                        <input type="text"
                                            class="form-control"
                                            id="place-of-birth"
                                            name="place-of-birth">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Date of Birth</label>
                                        <input type="date"
                                        class="form-control"
                                        id="date-of-birth"
                                        name="date-of-birth">
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
                            </div>
                            <div class="card-footer">
                                <button type="submit"
                                    class="btn btn-primary">Create</button>
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
