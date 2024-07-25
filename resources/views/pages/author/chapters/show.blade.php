@extends('layouts.app-author')

@section('title', $chapter->chapter . ' Detail')

@push('style')
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $chapter->chapter }} Detail</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @foreach ($files as $key => $file)
                                    <strong>{{ $key + 1 }}. {{ $file->type }}</strong>
                                    <ul class="list-group">
                                        @if ($file->type == 'Chapter')
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <i class="fas fa-file"></i>
                                                        <strong>{{ $file->name }}</strong>
                                                    </div>
                                                    <div class="col-md-1 text-right">
                                                        <a class="btn btn-secondary"
                                                            href="{{ Storage::url('upload/books/') . $file->name }}"
                                                            download="{{ $file->name }}"><i
                                                                class="fas fa-download"></i></a></td>
                                                    </div>
                                                    <div class="d-flex justify-content-between col-md-12 py-1">
                                                        <small>Author : {{ $file->user->username }}</small>
                                                        <small>Uploaded : {{ $file->uploaded_at }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if ($file->type == 'Review')
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <i class="fas fa-file"></i>
                                                        <strong>{{ $file->name }}</strong>
                                                    </div>
                                                    <div class="col-md-1 text-right">
                                                        <a class="btn btn-secondary"
                                                            href="{{ Storage::url('upload/books/') . $file->name }}"
                                                            download="{{ $file->name }}"><i
                                                                class="fas fa-download"></i></a>
                                                    </div>
                                                    <div class="d-flex justify-content-between col-md-12 py-1">
                                                        <small>Reviewer : {{ $file->user->username }}</small>
                                                        <small>Reviewed : {{ $file->uploaded }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if ($file->chapter->status->option == 'Revisi')
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <strong>Notes :</strong>
                                                        <br>
                                                        <p>{{ $file->notes }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        {{-- <li class="list-group-item">
                                            <form action="{{ route('author.upload.chapter', $chapter->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <input type="file" name="file_chapter" class="form-control-file"
                                                            accept=".doc,.docx" required>
                                                    </div>
                                                    <div class="col-md-2 text-right">
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fas fa-upload"></i> Upload</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </li> --}}
                                    </ul>
                                @endforeach
                                <form action="{{ route('author.upload.chapter', $chapter->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="file" name="file_chapter"
                                                class="form-control-file" accept=".doc,.docx" required>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-upload"></i> Upload</button>
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