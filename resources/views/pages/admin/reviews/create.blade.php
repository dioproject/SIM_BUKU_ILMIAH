@extends('layouts.app-admin')

@section('title', 'Create Review')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Reviews</div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('error') }}.
                    </div>
                </div>
            @endif

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
                                <form action="{{ route('admin.store.review') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Title</label>
                                            <select class="form-control selectric" tabindex="1" id="book_id"
                                                name="book_id" value="{{ old('book_id') }}">
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}"
                                                        @if (old('book_id') == $book->id) selected @endif>
                                                        {{ $book->manuscript->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Review</label>
                                            <textarea class="form-control" tabindex="2" data-height="150" id="content" name="content">{{ old('content') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
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
@endpush
