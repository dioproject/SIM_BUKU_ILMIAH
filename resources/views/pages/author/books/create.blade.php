@extends('layouts.app-author')

@section('title', 'Create Book')

@push('style')
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Book</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Books</a></div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Submission Book</h4>
                            </div>
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
                                <form id="create-book-form" action="{{ route('author.store.book') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf                                    
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Chapter
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="file" tabindex="3" class="form-control" id="file_chapter"
                                                name="file_chapter" value="{{ old('file_chapter') }}" accept=".doc,.docx">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">File Chapter
                                            :</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="file" tabindex="3" class="form-control" id="file_chapter"
                                                name="file_chapter" value="{{ old('file_chapter') }}" accept=".doc,.docx">
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
@endpush
