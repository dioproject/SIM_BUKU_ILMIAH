@extends('layouts.app-admin')

@section('title', 'Book Detail')

@push('style')
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $book->title }} Book Detail</h1>
            </div>
            @php
                $totalChapters = (int) $book->total_chapter;
                $currentChaptersCount = $chapters->count();
            @endphp
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @if ($currentChaptersCount < $totalChapters)
                                    <form action="{{ route('admin.store.chapter', $book->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        @for ($i = $currentChaptersCount + 1; $i <= $totalChapters; $i++)
                                            <div class="form-group row mb-4">
                                                <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Chapter
                                                    {{ $i }}
                                                    :</label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input type="text" tabindex="1" class="form-control" id="chapter"
                                                        name="chapter[]" value="{{ old('chapter.' . ($i - 1)) }}">
                                                </div>
                                            </div>
                                        @endfor

                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                            <div class="col-sm-12 col-md-9">
                                                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                                    Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                @foreach ($chapters as $key => $chapter)
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $key + 1 }}. {{ $chapter->chapter }}</strong>
                                        @if ($chapter->file_chapter)
                                            <small
                                                class="text-danger">{{ \Carbon\Carbon::parse($chapter->deadline)->translatedFormat('l, d F Y') }}</small>
                                        @endif
                                    </div>
                                    <ul class="list-group py-2">
                                        @if ($chapter->file_chapter)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <i class="fas fa-file"></i>
                                                        <strong>{{ $chapter->file_chapter }}</strong>
                                                    </div>
                                                    <div class="col-md-1 text-right">
                                                        <a class="btn btn-secondary"
                                                            href="{{ Storage::url('upload/books/') . $chapter->file_chapter }}"
                                                            download="{{ $chapter->file_chapter }}"><i
                                                                class="fas fa-download"></i></a></td>
                                                    </div>
                                                    <div class="d-flex justify-content-between col-md-12 py-1">
                                                        <small>Author : {{ $chapter->author->username }}</small>
                                                        <small>Uploaded :
                                                            {{ \Carbon\Carbon::parse($chapter->uploaded_at)->translatedFormat('l, d F Y') }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if ($chapter->file_review)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <i class="fas fa-file"></i>
                                                        <strong>{{ $chapter->file_review }}</strong>
                                                    </div>
                                                    <div class="col-md-1 text-right">
                                                        <a class="btn btn-secondary"
                                                            href="{{ Storage::url('upload/books/') . $chapter->file_review }}"
                                                            download="{{ $chapter->file_review }}"><i
                                                                class="fas fa-download"></i></a></td>
                                                    </div>
                                                    <div class="d-flex justify-content-between col-md-12 py-1">
                                                        <small>Reviewer : {{ $chapter->reviewer->username }}</small>
                                                        <small>Reviewed :
                                                            {{ \Carbon\Carbon::parse($chapter->updated_at)->translatedFormat('l, d F Y') }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if ($chapter->notes)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <strong>Notes :</strong>
                                                        <br>
                                                        <p>{{ $chapter->notes }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                @endforeach
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
