@extends('layouts.app-admin')

@section('title', 'Reviews')

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
                                        <div class="form-group col-md-4">
                                            <label>Category</label>
                                            <select class="form-control selectric" tabindex="1" id="category"
                                                name="category" value="{{ old('category') }}">
                                                @foreach ($category as $cate)
                                                    <option value="{{ $cate->id }}"
                                                        @if (old('category') == $cate->id) selected @endif>
                                                        {{ $cate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Title</label>
                                            <select class="form-control selectric" tabindex="2" id="title"
                                                name="title" value="{{ old('title') }}">
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}"
                                                        @if (old('title') == $book->id) selected @endif>
                                                        {{ $book->manuscript->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Abstract</label>
                                            <textarea aria-hidden="true" disabled class="form-control" tabindex="3" id="abstract" name="abstract" value="">{{ old('abstract') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Fill</label>
                                            <textarea aria-hidden="true" disabled class="form-control" tabindex="4" id="fill" name="fill">{{ old('fill') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Review</label>
                                            <textarea class="form-control" tabindex="5" data-height="150" id="content" name="content">{{ old('content') }}</textarea>
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
