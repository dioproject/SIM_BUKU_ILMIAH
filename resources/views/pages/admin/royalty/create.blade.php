@extends('layouts.app-admin')

@section('title', 'Create Royalty')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/select2/dist/css/select2.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Royalty</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/admin/royalty">Royalty</a></div>
                    <div class="breadcrumb-item active"><a href="/admin/royalty">Create</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Writer</label>
                                        <select class="form-control select2">
                                            <option>John doe</option>
                                            <option>Opet</option>
                                            <option>SItohang</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Book</label>
                                        <select class="form-control select2">
                                            <option>Semleho</option>
                                            <option>Derita Hati</option>
                                            <option>SItohang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Royalties for the Month</label>
                                        <input type="date"
                                            class="form-control"
                                            id="royalty"
                                            name="royalty">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-control-label">Proof of Payment</label>
                                        <div class="form-control custom-file">
                                            <input type="file"
                                                name="proof-payment"
                                                class="custom-file-input"
                                                id="proof-payment">
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
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
