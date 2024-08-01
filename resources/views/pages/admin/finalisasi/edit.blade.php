@extends('layouts.app-admin')

@section('title', 'Edit finalisasi {{ $finalisasi->buku->judul }}')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit finalisasi {{ $finalisasi->buku->judul }}</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form id="form-validation" action="{{ route('admin.update.finalisasi', $finalisasi->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-4 col-lg-2">ISBN :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" tabindex="1" class="form-control" id="isbn"
                                                name="isbn" value="{{ $finalisasi->isbn }} {{ old('isbn') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Cover :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="file" tabindex="2" class="form-control" id="cover"
                                                name="cover" value="{{ $finalisasi->cover }} {{ old('cover') }}" accept=".jpg,.jpeg,.png">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Final File :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="file" tabindex="3" class="form-control" id="final_file"
                                                name="final_file" value="{{ $finalisasi->final_file }} {{ old('final_file') }}" accept=".pdf">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                        <div class="col-sm-12 col-md-9">
                                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                                Submit</button>
                                        </div>
                                    </div>
                                </form>
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
