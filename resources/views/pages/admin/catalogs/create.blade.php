@extends('layouts.app-admin')

@section('title', 'Create Catalog')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Catalog</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Catalogs</div>
                    <div class="breadcrumb-item">Create</div>
                </div>
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
                                <form action="{{ route('admin.create.catalog') }}" method="POST"
                                    enctype="multipart/form-data">
                                </form>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Title</label>
                                        <select class="form-control selectric" tabindex="1" id="bookTitle" name="bookTitle"
                                            value="{{ old('bookTitle') }}">
                                            @foreach ($bookTitle as $bt)
                                                <option value="{{ $bt->id }}"
                                                    @if (old('religion') == $bt->id) selected @endif>
                                                    {{ $bt->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Photos</label>
                                        <div class="form-control custom-file">
                                            <input type="file" tabindex="2" name="path_foto" class="custom-file-input" id="path_foto" value="path_foto">
                                            <label class="custom-file-label">Choose File</label>
                                        </div>
                                        <div class="form-text text-muted">The image must have a maximum size of 1MB
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Description</label>
                                        <textarea type="text" tabindex="3" id="description" name="description" class="form-control" value="{{ old('description') }}" data-height="150"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
